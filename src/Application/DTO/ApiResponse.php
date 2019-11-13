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
    private $document;

    /**
     * ApiResponse constructor.
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }
}
