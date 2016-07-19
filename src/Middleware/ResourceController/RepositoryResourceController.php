<?php
namespace Reliv\PipeRat\Middleware\ResourceController;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\InvalidWhereException;
use Reliv\PipeRat\Exception\RepositoryException;
use Reliv\PipeRat\Hydrator\Hydrator;
use Reliv\PipeRat\Repository\Repository;

/**
 * Class RepositoryResourceController
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class RepositoryResourceController extends AbstractResourceController
{
    /**
     * @var ContainerInterface
     */
    protected $serviceManager;

    /**
     * @var Hydrator
     */
    protected $hydrator;

    /**
     * RepositoryResourceController constructor.
     *
     * @param ContainerInterface $serviceManager
     * @param Hydrator           $hydrator
     */
    public function __construct(
        $serviceManager,
        Hydrator $hydrator
    ) {
        $this->serviceManager = $serviceManager;
        $this->hydrator = $hydrator;
    }

    /**
     * getServiceManager
     *
     * @return ContainerInterface
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
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
     * getRepository
     *
     * @param Request $request
     *
     * @return mixed
     * @throws RepositoryException
     */
    public function getRepository(Request $request)
    {
        $repositoryName = $this->getRepositoryName($request);

        $repository = $this->getServiceManager()->get($repositoryName);

        if(!is_a($repository, 'Reliv\PipeRat\Repository\Repository')) {
            throw new RepositoryException(
                'Not a valid repository, must implement Reliv\PipeRat\Repository\Repository: ' . get_class($repository)
            );
        }

        return $repository;
    }

    /**
     * Adds the given entity to the DB.
     *
     * @param Request  $request
     * @param Response $response
     *
     * @return Response
     */
    public function create(Request $request, Response $response, callable $out)
    {
        $entityName = $this->getEntityName($request);
        $entity = new $entityName();

        $this->populateEntity($entity, $request);

        try {
            $result = $this->getRepository($request)->create($entity);
        } catch (RepositoryException $e) {
            return $response->withStatus(409);
        }

        return $out($request, $this->getResponseWithDataBody($response, $result));
    }

    /**
     * Updates the entity with the given ID with the request body.
     * If the entity is not in the DB, it will be created.
     *
     * @param Request  $request
     * @param Response $response
     * @param callable $out
     *
     * @return mixed
     */
    public function upsert(Request $request, Response $response, callable $out)
    {
        $idFieldName = $this->getEntityIdFieldName($request);
        $body = $request->getParsedBody();

        if (!array_key_exists($idFieldName, $body)) {
            return $response->withStatus(400);
        }

        $entityName = $this->getEntityName($request);
        $entity = new $entityName();
        $this->populateEntity($entity, $request);
        $result = $this->getRepository($request)->upsert($entity);

        return $out($request, $this->getResponseWithDataBody($response, $result));
    }

    /**
     * Returns 200, true if the entity with the given ID exists in DB.
     * Returns 404, false if the entity does not exist in DB.
     *
     * @param Request  $request
     * @param Response $response
     * @param callable $out
     *
     * @return \Reliv\PipeRat\Http\DataResponse|Response
     */
    public function exists(Request $request, Response $response, callable $out)
    {
        $id = $this->getRouteParam($request, 'id');

        if (empty($id)) {
            return $response->withStatus(400);
        }

        $result = $this->getRepository($request)->exists($id);

        if ($result) {
            return $out($request, $this->getResponseWithDataBody($response, true));
        }

        return $out($request, $this->getResponseWithDataBody($response->withStatus(404), false));
    }

    /**
     * Finds the the entity with the given ID and returns it.
     * If the entity is not in the DB, return 404.
     *
     * @param Request  $request
     * @param Response $response
     * @param callable $out
     *
     * @return Response
     */
    public function findById(Request $request, Response $response, callable $out)
    {
        $id = $this->getRouteParam($request, 'id');

        if (empty($id)) {
            return $response->withStatus(400);
        }

        $result = $this->getRepository($request)->findById($id);

        if (!is_object($result)) {
            return $out($request, $response->withStatus(404));
        }

        return $out($request, $this->getResponseWithDataBody($response, $result));
    }

    /**
     * Returns a list of all enitites that match the json encoded "where" query param.
     * If "where" is not in the query, all entities are returned.
     *
     * @param Request  $request
     * @param Response $response
     * @param callable $out
     *
     * @return mixed
     */
    public function find(Request $request, Response $response, callable $out)
    {
        $repository = $this->getRepository($request);

        try {
            $where = $this->getWhere($request);
        } catch (InvalidWhereException $e) {
            return $response->withStatus(400);
        }

        try {
            $results = $repository->find(
                $where,
                $this->getOrder($request),
                $this->getLimit($request),
                $this->getSkip($request)
            );
        } catch (RepositoryException $e) {
            return $response->withStatus(400);
        }

        return $out($request, $this->getResponseWithDataBody($response, $results));
    }

    /**
     * @param Request  $request
     * @param Response $response
     * @param callable $out
     *
     * @return mixed
     */
    public function findOne(Request $request, Response $response, callable $out)
    {
        $repository = $this->getRepository($request);

        try {
            $where = $this->getWhere($request);
        } catch (InvalidWhereException $e) {
            return $response->withStatus(400);
        }

        try {
            $result = $repository->findOne($where);
        } catch (RepositoryException $e) {
            return $response->withStatus(400);
        }

        if ($result === null) {
            return $response->withStatus(404);
        }

        return $out($request, $this->getResponseWithDataBody($response, $result));
    }

    /**
     * Deletes the entity with the give ID from the DB.
     *
     * @param Request  $request
     * @param Response $response
     * @param callable $out
     *
     * @return Response
     */
    public function deleteById(Request $request, Response $response, callable $out)
    {
        $id = $this->getRouteParam($request, 'id');

        if (empty($id)) {
            return $response->withStatus(400);
        }

        $result = $this->getRepository($request)->deleteById($id);

        if ($result === false) {
            return $response->withStatus(404);
        }

        return $out($request, $this->getResponseWithDataBody($response, $result));
    }

    /**
     * Returns the count of the entities given.
     *
     * @param Request  $request
     * @param Response $response
     * @param callable $out
     *
     * @return Response
     */
    public function count(Request $request, Response $response, callable $out)
    {
        try {
            $where = $this->getWhere($request);
        } catch (InvalidWhereException $e) {
            return $response->withStatus(400);
        }

        $repository = $this->getRepository($request);

        try {
            $result = $repository->count($where);
        } catch (RepositoryException $e) {
            return $response->withStatus(400);
        }

        return $out($request, $this->getResponseWithDataBody($response, $result));
    }

    /**
     * Updates the entity with the given ID with the request body.
     * IF the entity is not in the DB, return 404.
     *
     * @param Request  $request
     * @param Response $response
     * @param callable $out
     *
     * @return Response
     */
    public function updateProperties(
        Request $request,
        Response $response,
        callable $out
    ) {
        $id = $this->getRouteParam($request, 'id');

        if (empty($id)) {
            return $response->withStatus(400);
        }

        $repository = $this->getRepository($request);
        $properties = $request->getParsedBody();

        $result = $repository->updateProperties($id, $properties);

        if ($result === null) {
            return $response->withStatus(404);
        }

        return $out($request, $this->getResponseWithDataBody($response, $result));
    }

    /**
     * getEntityIdFieldName
     *
     * @param Request $request
     *
     * @return mixed
     */
    protected function getEntityIdFieldName(Request $request)
    {
        return $this->getOption($request, 'entityIdFieldName', null);
    }

    /**
     * getEntityName
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function getEntityName(Request $request)
    {
        return $this->getOption($request, 'entity', null);
    }

    /**
     * getRepositoryName
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function getRepositoryName(Request $request)
    {
        return $this->getOption($request, 'repository', null);
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
     * @return void
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
