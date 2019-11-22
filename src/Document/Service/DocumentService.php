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
use Psr\Log\LoggerInterface;

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
     * @var LoggerInterface
     */
    private $logger;

    /**
     * DocumentService constructor.
     *
     * @param DocumentRepositoryInterface $repository
     * @param LoggerInterface             $logger
     */
    public function __construct(DocumentRepositoryInterface $repository, LoggerInterface $logger)
    {
        $this->repository = $repository;
        $this->logger= $logger;
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
        $this->logger->debug('Create document with payload {payload} for owner {owner_id} and create date {create_at}', [
            'payload' => $payload,
            'owner_id' => $ownerId,
            'create_at' => $createDateTime,
        ]);
        $document = new Document();
        $document->setOwnerId($ownerId);
        if ($createDateTime !== null) {
            $document->setCrateAt($createDateTime);
        }

        try {
            return $this->repository->save($document);
        } catch (PersistenceException $pe) {
            $this->logger->error($pe);
            throw new LogicException('Error occurs while save document', 0, $pe);
        } catch (\Exception $e) {
            $this->logger->error($e);
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
        $this->logger->debug('Update document with payload {payload} for owner {owner_id} and update date {modify_at}', [
            'payload' => $payload,
            'owner_id' => $ownerId,
            'modify_at' => $updateDateTime,
        ]);
        try {
            $document = $this->fetchDocument($ownerId, $documentId);

            if ($document->getStatus() === Document::STATUS_PUBLISHED) {
                $this->logger->error('Can\'t update document with id {document_id}: document already published', [
                    'document_id' => $documentId,
                ]);
                throw new DocumentStatusException('Can\'t update document: document already published');
            }

            // creates historical entry
            $this->createVersionFromDocument($document);

            $document->setPayload($payload);
            $document->setModifyAt(new \DateTime());

            return $this->repository->save($document);
        } catch (PersistenceException $pe) {
            $this->logger->error($pe);
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
        $this->logger->debug('Publishing document with id {document_id} for owner {owner_id}', [
            'document_id' => $documentId,
            'owner_id' => $ownerId,
        ]);

        try {
            $document = $this->fetchDocument($ownerId, $documentId);
            if ($document->getStatus() === Document::STATUS_DRAFT) {
                $document->setStatus(Document::STATUS_PUBLISHED);
                $document->setModifyAt(new \DateTime());

                return $this->repository->save($document);
            }

            return $document;
        } catch (PersistenceException $pe) {
            $this->logger->error($pe);
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
            $this->logger->error('Document with id {document_id} for owner {owner_id} not found', [
                'document_id' => $documentId,
                'owner_id' => $ownerId,
            ]);
            throw new DocumentNotFoundException('Document not found');
        }

        return $document;
    }

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
    public function fetchDocumentVersions(string $ownerId, string $documentId, int $page = 1, int $limit = 20): Map
    {
        $total = $this->repository->getTotalVersionsByOwnerIdAndDocumentId($ownerId, $documentId);

        $offset = $limit * ($page-1);

        $collection =  $this->repository->fetchVersionsByOwnerIdAndDocumentId($ownerId, $documentId, $limit, $offset);

        return new Map(['total' => $total, 'collection' => $collection]);
    }

    /**
     * Create new version from existent document.
     *
     * @param DocumentInterface $document
     *
     * @return DocumentInterface
     */
    private function createVersionFromDocument(DocumentInterface $document): DocumentInterface
    {
        $document = new Document();
        $document->setOwnerId($document->getOwnerId());
        $document->setStatus($document->getStatus());
        $document->setPayload($document->getPayload());
        $document->setParentId($document->getId());

        try {
            return $this->repository->save($document);
        } catch (PersistenceException $pe) {
            $this->logger->error($pe);
            throw new LogicException('Error occurs while save document', 0, $pe);
        } catch (\Exception $e) {
            $this->logger->error($e);
            throw new LogicException("Can't create new document", 0, $e);
        }
    }
}
