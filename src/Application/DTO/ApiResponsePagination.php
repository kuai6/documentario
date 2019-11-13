<?php

declare(strict_types=1);

namespace Application\DTO;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Api response with pagination"
 * )
 *
 * Class ApiResponse
 */
class ApiResponsePagination
{
    /**
     * @OA\Property(
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/Document")
     * )
     *
     * @var array
     */
    private $document = [];

    /**
     * @OA\Property()
     *
     * @var Pagination
     */
    private $pagination;

    /**
     * ApiResponsePagination constructor.
     *
     * @param Document $document
     */
    public function __construct(array $document, Pagination $pagination)
    {
        $this->document = $document;
        $this->pagination = $pagination;
    }
}
