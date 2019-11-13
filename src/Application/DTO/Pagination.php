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
    private $page;

    /**
     * @OA\Property(
     *     format="int",
     *     title="Items per page"
     * )
     *
     * @var int
     */
    private $perPage;

    /**
     * @OA\Property(
     *     format="int",
     *     title="Total"
     * )
     *
     * @var int
     */
    private $total;

    /**
     * Pagination constructor.
     */
    public function __construct(int $page, int $perPage, int $total)
    {
        $this->page = $page;
        $this->perPage = $perPage;
        $this->total = $total;
    }
}
