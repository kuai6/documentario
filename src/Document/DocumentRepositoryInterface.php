<?php

declare(strict_types=1);

namespace Document;

use Document\Exception\PersistenceException;

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
     * @return array
     */
    public function fetchAllByOwnerId(string $ownerId, int $limit, int $offset): array;
}
