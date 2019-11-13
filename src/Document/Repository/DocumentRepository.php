<?php

declare(strict_types=1);

namespace Document\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ConnectionException;
use Doctrine\DBAL\FetchMode;
use Document\DocumentInterface;
use Document\DocumentRepositoryInterface;
use Document\Entity\Document;
use Document\Exception\PersistenceException;
use Ramsey\Uuid\Uuid;

/**
 * Class DocumentRepository.
 */
class DocumentRepository implements DocumentRepositoryInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * DocumentRepository constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Save document to storage.
     *
     * @param DocumentInterface $document
     *
     * @return DocumentInterface
     *
     * @throws PersistenceException
     */
    public function save(DocumentInterface $document): DocumentInterface
    {
        if ($document->getId() === null) {
            return $this->insert($document);
        }

        return $this->update($document);
    }

    /**
     * Insert new Document into storage.
     *
     * @param DocumentInterface $document
     *
     * @return DocumentInterface
     *
     * @throws PersistenceException
     */
    private function insert(DocumentInterface $document): DocumentInterface
    {
        if (!$this->connection->beginTransaction()) {
            throw new PersistenceException("Can't start transaction");
        }

        try {
            $id = Uuid::uuid4()->toString();

            $qb = $this->connection->createQueryBuilder();
            $qb->insert('document')
                ->values([
                    'id'        => ':id',
                    'owner_id'  => ':owner_id',
                    'payload'   => ':payload',
                    'create_at' => ':create_at',
                    'modify_at' => ':modify_at',
                    'status'    => ':status',
                ])
                ->setParameters([
                    ':id'           => $id,
                    ':owner_id'     => $document->getOwnerId(),
                    ':payload'      => $document->getPayload(),
                    ':create_at'    => $document->getCrateAt()->format('Y-m-d H:i:s'),
                    ':modify_at'    => $document->getModifyAt()->format('Y-m-d H:i:s'),
                    ':status'       => $document->getStatus(),
                ])
                ->execute();
            $this->connection->commit();
            $document->setId($id);
        } catch (\Exception $e) {
            try {
                $this->connection->rollBack();
            } catch (ConnectionException $ce) {
                throw new PersistenceException("Can't rollback transaction", 0, $ce);
            }
            throw new PersistenceException("Can't finish transaction", 0, $e);
        }

        return $document;
    }

    /**
     * Update existing document in storage.
     *
     * @param DocumentInterface $document
     *
     * @return DocumentInterface
     *
     * @throws PersistenceException
     */
    private function update(DocumentInterface $document): DocumentInterface
    {
        if (!$this->connection->beginTransaction()) {
            throw new PersistenceException("Can't start transaction");
        }

        try {
            $qb = $this->connection->createQueryBuilder();
            $qb->update('document')
                ->set('payload', ':payload')
                ->set('modify_at', ':modify_at')
                ->set('status', ':status')
                ->setParameters([
                    ':payload'      => json_encode($document->getPayload()),
                    ':modify_at'    => $document->getModifyAt()->format('Y-m-d H:i:s'),
                    ':status'       => $document->getStatus(),
                ])
                ->execute();
            $this->connection->commit();
        } catch (\Exception $e) {
            try {
                $this->connection->rollBack();
            } catch (ConnectionException $ce) {
                throw new PersistenceException("Can't rollback transaction", 0, $ce);
            }
            throw new PersistenceException("Can't finish transaction", 0, $e);
        }

        return $document;
    }

    /**
     * Fetch collection of documents.
     *
     * @param int $limit
     * @param int $offset
     *
     * @return Document[]
     */
    public function fetchAll(int $limit, int $offset): array
    {
    }

    /**
     * Fetch one document.
     *
     * @param string $ownerId
     * @param string $id
     *
     * @return DocumentInterface|null
     */
    public function fetchByOwnerIdAndId(string $ownerId, string $id): ?DocumentInterface
    {
        try {
            $qb = $this->connection->createQueryBuilder();
            $result = $qb->select('*')
                ->from('document')
                ->where('id = :id')
                ->andWhere('owner_id = :owner_id')
                ->setParameters([
                    ':id' => $id,
                    ':owner_id' => $ownerId,
                ])
                ->execute()->fetch(FetchMode::ASSOCIATIVE);
            if ($result === false) {
                return null;
            }

            $doc = new Document();
            $doc->setId($result['id']);
            $doc->setOwnerId($result['owner_id']);
            if ($result['payload'] !== null) {
                $doc->setPayload(json_decode($result['payload']));
            }
            $doc->setCrateAt(new \DateTime($result['create_at']));
            $doc->setModifyAt(new \DateTime($result['modify_at']));
            $doc->setStatus($result['status']);

            return $doc;
        } catch (\Exception $e) {
            throw new PersistenceException("Can't fetch document by id", 0, $e);
        }
    }

    /**
     * Fetch collection of documents.
     *
     * @param string $ownerId
     * @param int    $limit
     * @param int    $offset
     *
     * @return array
     */
    public function fetchAllByOwnerId(string $ownerId, int $limit, int $offset): array
    {
        // TODO: Implement fetchAllByOwnerId() method.
    }
}
