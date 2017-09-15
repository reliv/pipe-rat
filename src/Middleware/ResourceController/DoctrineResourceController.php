<?php

namespace Reliv\PipeRat\Middleware\ResourceController;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\DoctrineEntityException;
use Reliv\PipeRat\Exception\InvalidWhereException;
use Reliv\PipeRat\Hydrator\Hydrator;

/**
 * Class DoctrineResourceController
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class DoctrineResourceController extends AbstractResourceController
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var Hydrator
     */
    protected $hydrator;

    /**
     * DoctrineResourceController constructor.
     *
     * @param EntityManager $entityManager
     * @param Hydrator $hydrator
     */
    public function __construct(
        EntityManager $entityManager,
        Hydrator $hydrator
    ) {
        $this->entityManager = $entityManager;
        $this->hydrator = $hydrator;
    }

    /**
     * getEntityManager
     *
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * getHydrator
     *
     * @return Hydrator
     */
    public function getHydrator()
    {
        return $this->hydrator;
    }

    /**
     * getEntityName
     *
     * @param Request $request
     *
     * @return string
     */
    protected function getEntityName(Request $request)
    {
        return $this->getOption($request, 'entity', null);
    }

    /**
     * Returns the entity by the ID that is in the request or
     * null if the ID is not in the DB.
     *
     * @param Request $request
     *
     * @return null|object
     */
    protected function getEntityByRequestId(Request $request)
    {
        $id = $this->getRouteParam($request, 'id');

        return $this->getRepository($request)->find($id);
    }

    /**
     * getRepository
     *
     * @param Request $request
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepository(Request $request)
    {
        $entityName = $this->getEntityName($request);

        return $this->getEntityManager()->getRepository($entityName);
    }

    /**
     * Adds the given entity to the DB.
     *
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function create(Request $request, Response $response, callable $next)
    {
        $entityName = $this->getEntityName($request);
        $entity = new $entityName();

        $this->populateEntity($entity, $request);

        $this->getEntityManager()->persist($entity);

        try {
            $this->getEntityManager()->flush($entity);
        } catch (UniqueConstraintViolationException $e) {
            return $response->withStatus(409);
        }

        $response = $this->getResponseWithDataBody($response, $entity);

        return $response;
    }

    /**
     * Updates the entity with the given ID with the request body.
     * If the entity is not in the DB, it will be created.
     *
     * @param Request $request
     * @param Response $response
     * @param callable $next
     *
     * @return mixed
     * @throws DoctrineEntityException
     */
    public function upsert(Request $request, Response $response, callable $next)
    {
        $idFieldName = $this->getEntityIdFieldName($this->getEntityName($request));
        $body = $request->getParsedBody();

        if (!array_key_exists($idFieldName, $body)) {
            return $response->withStatus(400);
        }

        $entity = $this->getRepository($request)->findOneBy([$idFieldName => $body[$idFieldName]]);

        if (!is_object($entity)) {
            $entityName = $this->getEntityName($request);
            $entity = new $entityName();
            $this->populateEntity($entity, $request);
            $this->getEntityManager()->persist($entity);
        } else {
            $this->populateEntity($entity, $request);
        }

        $this->getEntityManager()->flush($entity);

        $response = $this->getResponseWithDataBody($response, $entity);

        return $response;
    }

    /**
     * Returns 200, true if the entity with the given ID exists in DB.
     * Returns 404, false if the entity does not exist in DB.
     *
     * @param Request $request
     * @param Response $response
     * @param callable $next
     *
     * @return \Reliv\PipeRat\Http\DataResponse
     */
    public function exists(Request $request, Response $response, callable $next)
    {
        if (is_object($this->getEntityByRequestId($request))) {
            $response = $this->getResponseWithDataBody($response, true);

            return $response;
        }

        $response = $this->getResponseWithDataBody($response->withStatus(404), false);

        return $response;
    }

    /**
     * Finds the the entity with the given ID and returns it.
     * If the entity is not in the DB, return 404.
     *
     * @param Request $request
     * @param Response $response
     * @param callable $next
     *
     * @return Response
     */
    public function findById(Request $request, Response $response, callable $next)
    {
        $entity = $this->getEntityByRequestId($request);

        if (!is_object($entity)) {
            return $response->withStatus(404);
        }

        $response = $this->getResponseWithDataBody($response, $entity);

        return $response;
    }

    /**
     * Returns a list of all enitites that match the json encoded "where" query param.
     * If "where" is not in the query, all entities are returned.
     *
     * @param Request $request
     * @param Response $response
     * @param callable $next
     *
     * @return mixed
     */
    public function find(Request $request, Response $response, callable $next)
    {
        $repo = $this->getRepository($request);

        $where = $this->getWhere($request);

        try {
            $results = $repo->findBy(
                $where,
                $this->getOrder($request),
                $this->getLimit($request),
                $this->getSkip($request)
            );
        } catch (ORMException $e) {
            return $response->withStatus(400);
        }

        $response = $this->getResponseWithDataBody($response, $results);

        return $response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable $next
     *
     * @return mixed
     */
    public function findOne(Request $request, Response $response, callable $next)
    {
        $repo = $this->getRepository($request);

        try {
            $where = $this->getWhere($request);
        } catch (InvalidWhereException $e) {
            return $response->withStatus(400);
        }

        try {
            $results = $repo->findOneBy($where);
        } catch (ORMException $e) {
            return $response->withStatus(400);
        }

        $response = $this->getResponseWithDataBody($response, $results);

        return $response;
    }

    /**
     * Deletes the entity with the give ID from the DB.
     *
     * @param Request $request
     * @param Response $response
     * @param callable $next
     *
     * @return Response
     */
    public function deleteById(Request $request, Response $response, callable $next)
    {
        $entity = $this->getEntityByRequestId($request);

        if (!is_object($entity)) {
            return $response->withStatus(404);
        }

        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush($entity);

        $response = $this->getResponseWithDataBody($response, $entity);

        return $response;
    }

    /**
     * Returns the count of the entities given.
     *
     * @param Request $request
     * @param Response $response
     * @param callable $next
     *
     * @return Response
     */
    public function count(Request $request, Response $response, callable $next)
    {
        try {
            $where = $this->getWhere($request);
        } catch (InvalidWhereException $e) {
            return $response->withStatus(400);
        }

        if (empty($where)) {
            //When there is no "where", running a query is likely faster than findBy.
            $entityName = $this->getEntityName($request);
            $count = $this->getEntityManager()
                ->createQuery('SELECT COUNT(e) FROM ' . $entityName . ' e')
                ->getSingleScalarResult();

            $response = $this->getResponseWithDataBody($response, (int)$count);

            return $response;
        }

        $repo = $this->getRepository($request);

        try {
            $results = $repo->findBy($where);
        } catch (ORMException $e) {
            return $response->withStatus(400);
        }

        $response = $this->getResponseWithDataBody($response, $results);

        return $response;
    }

    /**
     * Updates the entity with the given ID with the request body.
     * IF the entity is not in the DB, return 404.
     *
     * @param Request $request
     * @param Response $response
     * @param callable $next
     *
     * @return Response
     * @throws DoctrineEntityException
     */
    public function updateProperties(
        Request $request,
        Response $response,
        callable $next
    ) {
        $entity = $this->getEntityByRequestId($request);

        if (!is_object($entity)) {
            return $response->withStatus(404);
        }

        $this->populateEntity($entity, $request);
        $this->getEntityManager()->flush($entity);

        $response = $this->getResponseWithDataBody($response, $entity);

        return $response;
    }

    /**
     * Asks doctrine for the entity's ID field name and calls the
     * appropriate setter to set the given entity's ID.
     *
     * @param $entity
     * @param $id
     *
     * @throws DoctrineEntityException
     * @throws \Doctrine\ORM\Mapping\MappingException
     */
    protected function setEntityId(
        $entity,
        $id
    ) {
        $entityName = get_class($entity);
        $idName = $this->getEntityIdFieldName($entityName);
        if (empty($idName)) {
            throw new DoctrineEntityException(
                'Could not get SingleIdentifierFieldName for entity ' . $entityName
            );
        }
        $setter = 'set' . ucfirst($idName);
        if (!method_exists($entity, $setter)) {
            throw new DoctrineEntityException(
                'The entity ' . $entityName . ' is missing function ' . $setter . '()'
            );
        }
        $entity->$setter($id);
    }

    /**
     * getEntityIdFieldName
     *
     * @param $entityName
     *
     * @return string
     * @throws \Doctrine\ORM\Mapping\MappingException
     */
    protected function getEntityIdFieldName($entityName)
    {
        $meta = $this->getEntityManager()->getClassMetadata($entityName);

        return $meta->getSingleIdentifierFieldName();
    }

    /**
     * Populates the given entity from the given request's body.
     * If an earlier middleware parses the body into the "body"
     * request attribute, that attribute will be used rather than
     * the un-parsed actual body of the request.
     *
     * @param         $entity
     * @param Request $request
     *
     * @throws DoctrineEntityException
     */
    protected function populateEntity(
        $entity,
        Request $request
    ) {
        $this->getHydrator()->hydrate(
            $request->getParsedBody(),
            $entity,
            $this->getOptions($request)
        );
    }
}
