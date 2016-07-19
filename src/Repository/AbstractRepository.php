<?php

namespace Reliv\PipeRat\Repository;

use Reliv\PipeRat\Exception\RepositoryException;

/**
 * Interface AbstractRepository
 *
 * @author    James Jervis <jjervis@relivinc.com>
 * @copyright 2016 Reliv International
 * @license   License.txt
 * @link      https://github.com/reliv
 */
abstract class AbstractRepository
{
    /**
     * create
     *
     * @param \stdClass $entity
     *
     * @return \stdClass
     * @throws RepositoryException
     */
    public function create($entity)
    {
        throw new RepositoryException('Create not supported for: ' . get_class($this));
    }

    /**
     * upsert
     *
     * @param \stdClass $entity
     *
     * @return mixed
     * @throws RepositoryException
     */
    public function upsert($entity)
    {
        throw new RepositoryException('Upsert not supported for: ' . get_class($this));
    }

    /**
     * exists
     *
     * @param int $id
     *
     * @return bool
     * @throws RepositoryException
     */
    public function exists($id)
    {
        throw new RepositoryException('Exists not supported for: ' . get_class($this));
    }

    /**
     * findById
     *
     * @param int $id
     *
     * @return \stdClass|null
     * @throws RepositoryException
     */
    public function findById($id)
    {
        throw new RepositoryException('FindById not supported for: ' . get_class($this));
    }

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
    public function find(array $criteria = [], array $orderBy = null, $limit = null, $offset = null)
    {
        throw new RepositoryException('Find not supported for: ' . get_class($this));
    }

    /**
     * findOne
     *
     * @param array $criteria
     *
     * @return \stdClass|null
     * @throws RepositoryException
     */
    public function findOne(array $criteria = [])
    {
        throw new RepositoryException('FindOne not supported for: ' . get_class($this));
    }

    /**
     * deleteById
     *
     * @param int $id
     *
     * @return bool
     * @throws RepositoryException
     */
    public function deleteById($id)
    {
        throw new RepositoryException('DeleteById not supported for: ' . get_class($this));
    }

    /**
     * count
     *
     * @param array $criteria
     *
     * @return int
     * @throws RepositoryException
     */
    public function count(array $criteria = [])
    {
        throw new RepositoryException('Count not supported for: ' . get_class($this));
    }

    /**
     * updateProperties
     *
     * @param int   $id
     * @param array $properties
     *
     * @return \stdClass
     * @throws RepositoryException
     */
    public function updateProperties($id, array $properties)
    {
        throw new RepositoryException('UpdateProperties not supported for: ' . get_class($this));
    }
}
