<?php

declare(strict_types=1);

namespace Application\DTO;

/**
 * @OA\Schema(
 *     title="Api request schema"
 * )
 */
class ApiRequest
{
    /**
     * @OA\Property()
     *
     * @var Document
     */
    public $document;

    /**
     * ApiRequest constructor.
     *
     * @param Document $document
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * @param array $requestData
     *
     * @return static
     */
    public static function buildFromRequest(array $requestData): self
    {
        $doc = new Document();
        $doc->payload = $requestData['payload'];

        return new self($doc);
    }
}
