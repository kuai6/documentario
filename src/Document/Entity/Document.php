<?php

declare(strict_types=1);

namespace Document\Entity;

use Document\DocumentInterface;

/**
 * Class Document.
 */
class Document implements DocumentInterface
{
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $ownerId;

    /**
     * @var string
     */
    private $payload;

    /**
     * @var \DateTime
     */
    private $crateAt;

    /**
     * @var \DateTime
     */
    private $modifyAt;

    /**
     * @var string
     */
    private $status;

    /**
     * @var array []Document
     */
    private $versions = [];

    /**
     * @var string
     */
    private $parentId;

    /**
     * Document constructor.
     */
    public function __construct()
    {
        $this->crateAt = new \DateTime();
        $this->modifyAt = new \DateTime();
        $this->status = self::STATUS_DRAFT;
    }

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getOwnerId(): string
    {
        return $this->ownerId;
    }

    /**
     * @param string $ownerId
     */
    public function setOwnerId(string $ownerId)
    {
        $this->ownerId = $ownerId;
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param mixed $payload
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return \DateTime
     */
    public function getCrateAt(): \DateTime
    {
        return $this->crateAt;
    }

    /**
     * @param \DateTime $crateAt
     */
    public function setCrateAt(\DateTime $crateAt)
    {
        $this->crateAt = $crateAt;
    }

    /**
     * @return \DateTime
     */
    public function getModifyAt(): \DateTime
    {
        return $this->modifyAt;
    }

    /**
     * @param \DateTime $modifyAt
     */
    public function setModifyAt(\DateTime $modifyAt)
    {
        $this->modifyAt = $modifyAt;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * @return string|null
     */
    public function getParentId(): ?string
    {
        return $this->parentId;
    }

    /**
     * @param string $parentId
     */
    public function setParentId(string $parentId)
    {
        $this->parentId = $parentId;
    }
}
