<?php

declare(strict_types=1);

namespace Document;

use Document\Exception\DocumentNotFoundException;
use Document\Exception\LogicException;
use Ds\Map;

/**
 * Interface DocumentServiceInterface.
 */
interface DocumentServiceInterface
{
    /**
     * Create a new document with save to storage.
     *
     * @param string         $ownerId
     * @param mixed          $payload
     * @param \DateTime|null $createDateTime
     *
     * @return DocumentInterface
     *
     * @throws LogicException
     */
    public function createDocument(string $ownerId, ?string $payload, \DateTime $createDateTime = null): DocumentInterface;

    /**
     * Update existing document.
     *
     * @param string         $ownerId
     * @param string         $documentId
     * @param string         $payload
     * @param \DateTime|null $updateDateTime
     *
     * @return DocumentInterface
     *
     * @throws DocumentNotFoundException
     * @throws LogicException
     */
    public function updateDocument(string $ownerId, string $documentId, string $payload, \DateTime $updateDateTime = null): DocumentInterface;

    /**
     * Publish existing document.
     *
     * @param string $ownerId
     * @param string $documentId
     *
     * @return DocumentInterface
     *
     * @throws DocumentNotFoundException
     * @throws LogicException
     */
    public function publishDocument(string $ownerId, string $documentId): DocumentInterface;

    /**
     * Fetch existing document.
     *
     * @param string $ownerId
     * @param string $documentId
     *
     * @return DocumentInterface
     *
     * @throws DocumentNotFoundException
     */
    public function fetchDocument(string $ownerId, string $documentId): DocumentInterface;

    /**
     * Fetch documents collection.
     *
     * @param string $ownerId
     * @param int    $page
     * @param int    $limit
     *
     * @return Map[total, collection]
     */
    public function fetchDocuments(string $ownerId, int $page = 1, int $limit = 20): Map;

    /**
     * Fetch document versions.
     *
     * @param string $ownerId
     * @param string $documentId
     * @param int    $page
     * @param int    $limit
     *
     * @return mixed
     */
    public function fetchDocumentVersions(string $ownerId, string $documentId, int $page = 1, int $limit = 20): Map;
}
