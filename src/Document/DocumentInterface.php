<?php

declare(strict_types=1);

namespace Document;

/**
 * Interface DocumentInterface.
 */
interface DocumentInterface
{
    /**
     * @return string|null
     */
    public function getId(): ?string;

    /**
     * @param string $id
     */
    public function setId(string $id);

    /**
     * @return string|null
     */
    public function getOwnerId(): string;

    /**
     * @param string $ownerId
     */
    public function setOwnerId(string $ownerId);

    /**
     * @return mixed
     */
    public function getPayload();

    /**
     * @param mixed $payload
     */
    public function setPayload($payload);

    /**
     * @return \DateTime
     */
    public function getCrateAt(): \DateTime;

    /**
     * @param \DateTime $crateAt
     */
    public function setCrateAt(\DateTime $crateAt);

    /**
     * @return \DateTime|null
     */
    public function getModifyAt(): \DateTime;

    /**
     * @param \DateTime $modifyAt
     */
    public function setModifyAt(\DateTime $modifyAt);

    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     * @param string $status
     */
    public function setStatus(string $status);

    /**
     * @return string|null
     */
    public function getParentId(): ?string;

    /**
     * @param string $parentId
     *
     * @return mixed
     */
    public function setParentId(string $parentId);
}
