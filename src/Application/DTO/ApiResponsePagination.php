<?php

declare(strict_types=1);

namespace Application\DTO;

use Ds\Vector;
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
    public $document = [];

    /**
     * @OA\Property()
     *
     * @var Pagination
     */
    public $pagination;

    /**
     * ApiResponsePagination constructor.
     *
     * @param array      $documentCollection
     * @param Pagination $pagination
     */
    public function __construct(array $documentCollection, Pagination $pagination)
    {
        $this->document = $documentCollection;
        $this->pagination = $pagination;
    }

    /**
     * @param Vector $collection
     * @param int    $page
     * @param int    $perPage
     * @param int    $total
     *
     * @return ApiResponsePagination
     */
    public static function buildFromCollection(Vector $collection, int $page, int $perPage, int $total): self
    {
        $documents = [];

        $collection->map(function ($item) use (&$documents) {
            $documents[] = Document::buildFromEntity($item);
        });

        return new self($documents, new Pagination($page, $perPage, $total));
    }
}
