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
    private $id;

    /**
     * @OA\Property(
     *     description="Document status",
     *     title="Status"
     * )
     *
     * @var string
     */
    private $status;

    /**
     * @OA\Property(
     *     description="Document payload",
     *     title="Payload"
     * )
     *
     * @var mixed
     */
    private $payload;

    /**
     * @OA\Property(
     *     description="Document creation date",
     *     title="CreateAt"
     * )
     *
     * @var string
     */
    private $createAt;

    /**
     *  @OA\Property(
     *     description="Document modification date",
     *     title="ModifyAt"
     * )
     *
     * @var string
     */
    private $modifyAt;
}
