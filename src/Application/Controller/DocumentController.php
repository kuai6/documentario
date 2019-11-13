<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Validator\DocumentValidator;
use Document\DocumentServiceInterface;
use OpenApi\Annotations as OA;
use Phalcon\Annotations\Annotation as Get;
use Phalcon\Annotations\Annotation as Patch;
use Phalcon\Annotations\Annotation as Post;
use Phalcon\Http\Response;

/**
 * @RoutePrefix('/api/v1')
 *
 * Class DocumentController
 */
class DocumentController extends Base
{
    private const PAGE_DEFAULT = 1;
    private const PER_PAGE_DEFAULT = 20;
    /**
     * @var DocumentServiceInterface
     */
    private $documentService;

    /**
     * @var DocumentValidator
     */
    private $documentValidator;

    /**
     * @return DocumentController
     */
    public function setDocumentService(DocumentServiceInterface $documentService): self
    {
        $this->documentService = $documentService;

        return $this;
    }

    /**
     * @return DocumentController
     */
    public function setDocumentValidator(DocumentValidator $documentValidator): self
    {
        $this->documentValidator = $documentValidator;

        return $this;
    }

    /**
     * Fetch documents.
     *
     * @OA\Get(
     *     path="/document/",
     *     summary="Returns collection of documents",
     *     operationId="fetchDocuments",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for display results",
     *         required=false,
     *         allowEmptyValue=true,
     *         @OA\Schema(
     *            type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="perPage",
     *         in="query",
     *         description="Per page documents count",
     *         required=false,
     *         allowEmptyValue=true,
     *         @OA\Schema(
     *            type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ApiResponsePagination")
     *         )
     *     )
     * )
     *
     * @Get(
     *     '/document/'
     * )
     */
    public function fetchDocumentsAction(): Response
    {
        $page = $this->request->getQuery('page', ['int!'], self::PAGE_DEFAULT);
        $perPage = $this->request->getQuery('perPage', ['int!'], self::PER_PAGE_DEFAULT);

        if ($page <= 0) {
            $page = self::PAGE_DEFAULT;
        }

        if ($perPage <= 0) {
            $page = self::PER_PAGE_DEFAULT;
        }

        $response = new Response();
        $response->setJsonContent(['page' => $page, 'perPage' => $perPage]);

        return $response;
    }

    /**
     * Fetch document by ID.
     *
     * @OA\Get(
     *     path="/document/{id}",
     *     summary="Fetch document by its id",
     *     operationId="fetchDocument",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The id of document",
     *         required=true,
     *         allowEmptyValue=false,
     *         @OA\Schema(
     *            type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ApiResponse")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Document not found"
     *     )
     * )
     *
     * @Get(
     *     '/document/{id:[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}}'
     * )
     */
    public function fetchDocumentAction(string $id): Response
    {
        $response = new Response();
        $response->setJsonContent(['id' => $id]);

        return $response;
    }

    /**
     * Create new document.
     *
     * @OA\Post(
     *     path="/document/",
     *     summary="Create document",
     *     operationId="createDocument",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ApiResponse")
     *     ),
     *     @OA\Response(
     *         response=503,
     *         description="Internal server error"
     *     )
     * )
     *
     * @Post(
     *     '/document/'
     * )
     */
    public function createDocumentAction(): Response
    {
        $response = new Response();
        $response->setJsonContent([__METHOD__]);

        return $response;
    }

    /**
     * Update existing document.
     *
     * @OA\Patch(
     *     path="/document/{id}",
     *     summary="Update existing document",
     *     operationId="updateDocument",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ApiResponse")
     *     ),
     *     @OA\Response(
     *         response=503,
     *         description="Internal server error"
     *     )
     * )
     *
     * @Patch(
     *      '/document/{id:[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}}'
     * )
     */
    public function updateDocumentAction(string $id): Response
    {
        $response = new Response();
        $response->setJsonContent(['id' => $id]);

        return $response;
    }

    /**
     * Publish existing document.
     *
     * @OA\Post(
     *     path="/document/{id}/publish",
     *     summary="Publish existing document",
     *     operationId="publishDocument",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/ApiResponse")
     *     ),
     *     @OA\Response(
     *         response=503,
     *         description="Internal server error"
     *     )
     * )
     *
     * @Post(
     *      '/document/{id:[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}}/publish'
     * )
     */
    public function publishDocumentAction(string $id): Response
    {
        $response = new Response();
        $response->setJsonContent(['id' => $id]);

        return $response;
    }
}
