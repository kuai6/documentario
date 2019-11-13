<?php

declare(strict_types=1);

namespace Application\DTO;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Api response schema"
 * )
 *
 * Class ApiResponse
 */
class ApiResponse
{
    /**
     * @OA\Property()
     *
     * @var Document
     */
    public $document;

    /**
     * ApiResponse constructor.
     *
     * @param Document $document
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * @param \Document\Entity\Document $entity
     *
     * @return ApiResponse
     */
    public static function buildFromEntity(\Document\Entity\Document $entity): self
    {
        return new self(Document::buildFromEntity($entity));
    }
}
