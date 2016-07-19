<?php

namespace Reliv\PipeRat\Repository;

use Reliv\PipeRat\Exception\RepositoryException;

/**
 * Interface Repository
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
interface Repository
{
    /**
     * create
     *
     * @param \stdClass $entity
     *
     * @return \stdClass
     * @throws RepositoryException
     */
    public function create($entity);

    /**
     * upsert
     *
     * @param \stdClass $entity
     *
     * @return mixed
     * @throws RepositoryException
     */
    public function upsert($entity);

    /**
     * exists
     *
     * @param int $id
     *
     * @return bool
     * @throws RepositoryException
     */
    public function exists($id);

    /**
     * findById
     *
     * @param int $id
     *
     * @return \stdClass|null
     * @throws RepositoryException
     */
    public function findById($id);

    /**
     * find
     *
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     *
     * @return array
     * @throws RepositoryException
     */
    public function find(array $criteria = [], array $orderBy = null, $limit = null, $offset = null);

    /**
     * findOne
     *
     * @param array $criteria
     *
     * @return \stdClass|null
     * @throws RepositoryException
     */
    public function findOne(array $criteria = []);

    /**
     * deleteById
     *
     * @param int $id
     *
     * @return bool (success)
     * @throws RepositoryException
     */
    public function deleteById($id);

    /**
     * count
     *
     * @param array $criteria
     *
     * @return int
     * @throws RepositoryException
     */
    public function count(array $criteria = []);

    /**
     * updateProperties
     *
     * @param int   $id
     * @param array $properties
     *
     * @return \stdClass
     * @throws RepositoryException
     */
    public function updateProperties($id, array $properties);
}
