<?php

declare(strict_types=1);

namespace Document;

use Document\Exception\PersistenceException;
use Ds\Vector;

/**
 * Interface DocumentRepositoryInterface.
 */
interface DocumentRepositoryInterface
{
    /**
     * Save document to storage.
     *
     * @param DocumentInterface $document
     *
     * @return DocumentInterface
     *
     * @throws PersistenceException
     */
    public function save(DocumentInterface $document): DocumentInterface;

    /**
     * Fetch one document.
     *
     * @param string $ownerId
     * @param string $id
     *
     * @return DocumentInterface|null
     */
    public function fetchByOwnerIdAndId(string $ownerId, string $id): ?DocumentInterface;

    /**
     * Fetch collection of documents.
     *
     * @param string $ownerId
     * @param int    $limit
     * @param int    $offset
     *
     * @return Vector
     */
    public function fetchAllByOwnerId(string $ownerId, int $limit, int $offset): Vector;

    /**
     * Fetch collection of version specified documents.
     *
     * @param string $ownerId
     * @param string $documentId
     * @param int    $limit
     * @param int    $offset
     *
     * @return Vector
     */
    public function fetchVersionsByOwnerIdAndDocumentId(string $ownerId, string $documentId, int $limit, int $offset): Vector;

    /**
     * Get total documents count.
     *
     * @param string $ownerId
     *
     * @return int
     */
    public function getTotalByOwnerId(string $ownerId): int;

    /**
     * Fetch total document versions count.
     *
     * @param string $ownerId
     * @param string $id
     *
     * @return int
     */
    public function getTotalVersionsByOwnerIdAndDocumentId(string $ownerId, string $id): int;
}
