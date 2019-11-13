<?php

declare(strict_types=1);

namespace Application\DTO;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Pagination schema"
 * )
 *
 * Class Pagination
 */
class Pagination
{
    /**
     * @OA\Property(
     *     format="int",
     *     title="Page number"
     * )
     *
     * @var int
     */
    public $page;

    /**
     * @OA\Property(
     *     format="int",
     *     title="Items per page"
     * )
     *
     * @var int
     */
    public $perPage;

    /**
     * @OA\Property(
     *     format="int",
     *     title="Total"
     * )
     *
     * @var int
     */
    public $total;

    /**
     * Pagination constructor.
     *
     * @param int $page
     * @param int $perPage
     * @param int $total
     */
    public function __construct(int $page, int $perPage, int $total)
    {
        $this->page = $page;
        $this->perPage = $perPage;
        $this->total = $total;
    }
}
