<?php

namespace Reliv\PipeRat\Middleware\ResourceController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Reliv\PipeRat\Exception\InvalidWhereException;
use Reliv\PipeRat\Exception\ResourceControllerException;
use Reliv\PipeRat\Hydrator\Hydrator;

/**
 * Class ResourceController
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
class ResourceController extends AbstractResourceController
{
    /**
     * @var Hydrator
     */
    protected $hydrator;

    /**
     * ResourceController constructor.
     *
     * @param Hydrator $hydrator
     */
    public function __construct(
        Hydrator $hydrator
    ) {
        $this->hydrator = $hydrator;
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
     * Create a give item
     *
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function create(Request $request, Response $response, callable $out)
    {
        return $response->withStatus(404);
    }

    /**
     * Updates the entity with the given ID with the request body.
     * If the entity is not in the DB, it will be created.
     *
     * @param Request $request
     * @param Response $response
     * @param callable $out
     *
     * @return Response
     */
    public function upsert(Request $request, Response $response, callable $out)
    {
        return $response->withStatus(404);
    }

    /**
     * Returns 200, true if the entity with the given ID exists in DB.
     * Returns 404, false if the entity does not exist in DB.
     *
     * @param Request $request
     * @param Response $response
     * @param callable $out
     *
     * @return Response
     */
    public function exists(Request $request, Response $response, callable $out)
    {
        $idField = $this->getEntityIdFieldName($request);

        return $response->withStatus(404);
    }

    /**
     * Finds the the entity with the given ID and returns it.
     * If the entity is not in the DB, return 404.
     *
     * @param Request $request
     * @param Response $response
     * @param callable $out
     *
     * @return Response
     */
    public function findById(Request $request, Response $response, callable $out)
    {
        $idField = $this->getEntityIdFieldName($request);

        return $response->withStatus(404);
    }

    /**
     * Returns a list of all enitites that match the json encoded "where" query param.
     * If "where" is not in the query, all entities are returned.
     *
     * @param Request $request
     * @param Response $response
     * @param callable $out
     *
     * @return mixed
     */
    public function find(Request $request, Response $response, callable $out)
    {
        try {
            $where = $this->getWhere($request);
        } catch (InvalidWhereException $e) {
            return $response->withStatus(400);
        }

        $order = $this->getOrder($request);
        $limit = $this->getLimit($request);
        $skip = $this->getSkip($request);

        return $response->withStatus(404);
    }

    /**
     * entity
     * @param Request $request
     * @param Response $response
     * @param callable $out
     *
     * @return mixed
     */
    public function findOne(Request $request, Response $response, callable $out)
    {
        try {
            $where = $this->getWhere($request);
        } catch (InvalidWhereException $e) {
            return $response->withStatus(400);
        }

        return $response->withStatus(404);
    }

    /**
     * Deletes the entity with the give ID from the DB.
     *
     * @param Request $request
     * @param Response $response
     * @param callable $out
     *
     * @return Response
     */
    public function deleteById(Request $request, Response $response, callable $out)
    {
        $idField = $this->getEntityIdFieldName($request);

        return $response->withStatus(404);
    }

    /**
     * Returns the count of the entities given.
     *
     * @param Request $request
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

        return $response->withStatus(404);
    }

    /**
     * Updates the entity with the given ID with the request body.
     * IF the entity is not in the DB, return 404.
     *
     * @param Request $request
     * @param Response $response
     * @param callable $out
     *
     * @return Response
     * @throws ResourceControllerException
     */
    public function updateProperties(
        Request $request,
        Response $response,
        callable $out
    ) {
        return $response->withStatus(404);
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
     * Populates the given entity from the given request's body.
     * If an earlier middleware parses the body into the "body"
     * request attribute, that attribute will be used rather than
     * the un-parsed actual body of the request.
     *
     * @param         $entity
     * @param Request $request
     *
     * @throws ResourceControllerException
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
