<?php

declare(strict_types=1);

namespace Document\Service;

use Document\DocumentInterface;
use Document\DocumentRepositoryInterface;
use Document\DocumentServiceInterface;
use Document\Entity\Document;
use Document\Exception\DocumentNotFoundException;
use Document\Exception\DocumentStatusException;
use Document\Exception\LogicException;
use Document\Exception\PersistenceException;
use Ds\Map;

/**
 * Class Document.
 */
class DocumentService implements DocumentServiceInterface
{
    /**
     * @var DocumentRepositoryInterface
     */
    private $repository;

    /**
     * DocumentService constructor.
     *
     * @param DocumentRepositoryInterface $repository
     */
    public function __construct(DocumentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new document with save to storage.
     *
     * @param string         $ownerId
     * @param string         $payload
     * @param \DateTime|null $createDateTime
     *
     * @return DocumentInterface
     */
    public function createDocument(string $ownerId, ?string $payload, \DateTime $createDateTime = null): DocumentInterface
    {
        $document = new Document();
        $document->setOwnerId($ownerId);
        if ($createDateTime !== null) {
            $document->setCrateAt($createDateTime);
        }

        try {
            return $this->repository->save($document);
        } catch (PersistenceException $pe) {
            throw new LogicException('Error occurs while save document', 0, $pe);
        } catch (\Exception $e) {
            throw new LogicException("Can't create new document", 0, $e);
        }
    }

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
     * @throws DocumentStatusException
     * @throws LogicException
     * @throws \Exception
     */
    public function updateDocument(string $ownerId, string $documentId, $payload, \DateTime $updateDateTime = null): DocumentInterface
    {
        try {
            $document = $this->fetchDocument($ownerId, $documentId);
            if ($document->getStatus() === Document::STATUS_PUBLISHED) {
                throw new DocumentStatusException('Document already published');
            }

            $document->setPayload($payload);
            $document->setModifyAt(new \DateTime());

            return $this->repository->save($document);
        } catch (PersistenceException $pe) {
            throw new LogicException('Error occurs while update document', 0, $pe);
        }
    }

    /**
     * Publish existing document.
     *
     * @param string $ownerId
     * @param string $documentId
     *
     * @return DocumentInterface
     *
     * @throws \Exception
     */
    public function publishDocument(string $ownerId, string $documentId): DocumentInterface
    {
        try {
            $document = $this->fetchDocument($ownerId, $documentId);
            if ($document->getStatus() === Document::STATUS_DRAFT) {
                $document->setStatus(Document::STATUS_PUBLISHED);
                $document->setModifyAt(new \DateTime());

                return $this->repository->save($document);
            }

            return $document;
        } catch (PersistenceException $pe) {
            throw new LogicException('Error occurs while publish document', 0, $pe);
        }
    }

    /**
     * Fetch documents collection.
     *
     * @param string $ownerId
     * @param int    $page
     * @param int    $limit
     *
     * @return Map
     */
    public function fetchDocuments(string $ownerId, int $page = 1, int $limit = 20): Map
    {
        $total = $this->repository->getTotalByOwnerId($ownerId);

        $offset = $limit * ($page-1);
        $collection =  $this->repository->fetchAllByOwnerId($ownerId, $limit, $offset);

        return new Map(['total' => $total, 'collection' => $collection]);
    }

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
    public function fetchDocument(string $ownerId, string $documentId): DocumentInterface
    {
        $document = $this->repository->fetchByOwnerIdAndId($ownerId, $documentId);
        if ($document === null) {
            throw new DocumentNotFoundException('Document not found');
        }

        return $document;
    }
}
