<?php

declare(strict_types=1);

namespace Application\DTO;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     description="Document schema",
 *     title="Document schema"
 * )
 *
 * Class Document
 */
class Document
{
    /**
     * @OA\Property(
     *     description="Document id",
     *     title="Id"
     * )
     *
     * @var string
     */
    public $id;

    /**
     * @OA\Property(
     *     description="Document status",
     *     title="Status"
     * )
     *
     * @var string
     */
    public $status;

    /**
     * @OA\Property(
     *     description="Document payload",
     *     title="Payload"
     * )
     *
     * @var string|null
     */
    public $payload;

    /**
     * @OA\Property(
     *     description="Document creation date",
     *     title="CreateAt"
     * )
     *
     * @var string
     */
    public $createAt;

    /**
     *  @OA\Property(
     *     description="Document modification date",
     *     title="ModifyAt"
     * )
     *
     * @var string|null
     */
    public $modifyAt;

    /**
     * Document constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param \Document\Entity\Document $entity
     *
     * @return Document
     */
    public static function buildFromEntity(\Document\Entity\Document $entity): self
    {
        $doc = new self();
        $doc->id = $entity->getId();
        $doc->status = $entity->getStatus();
        $doc->payload =  $entity->getPayload();
        $doc->createAt = $entity->getCrateAt()->format('c');
        $doc->modifyAt = $entity->getModifyAt()->format('c');

        return $doc;
    }
}
