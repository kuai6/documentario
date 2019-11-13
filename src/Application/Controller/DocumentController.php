<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\DTO\ApiRequest;
use Application\DTO\ApiResponse;
use Application\DTO\ApiResponsePagination;
use Application\Validator\UpdateRequestValidator;
use Document\Entity\Document;
use Document\Exception\DocumentNotFoundException;
use Document\Exception\LogicException;
use Document\Service\DocumentService;
use Exception;
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

    private const OWNER_ID = 'f5e08ec7-8a56-e311-8719-0025906126df';

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
     *
     * @return Response
     */
    public function fetchDocumentsAction(): Response
    {
        $page = $this->request->getQuery('page', ['int!'], self::PAGE_DEFAULT);
        $perPage = $this->request->getQuery('perPage', ['int!'], self::PER_PAGE_DEFAULT);

        if ($page <= 0) {
            $page = self::PAGE_DEFAULT;
        }

        if ($perPage <= 0) {
            $perPage = self::PER_PAGE_DEFAULT;
        }

        /** @var DocumentService $documentService */
        $documentService = $this->getDI()->get(DocumentService::class);
        $response = new Response();

        try {
            $map = $documentService->fetchDocuments(self::OWNER_ID, $page, $perPage);
            $response->setJsonContent(ApiResponsePagination::buildFromCollection(
                $map->get('collection'),
                $page,
                $perPage,
                $map->get('total')
            ));
        } catch (DocumentNotFoundException $ne) {
            $response->setStatusCode(404, 'Not found');
        } catch (LogicException $le) {
            $response->setStatusCode(503, 'Service unavailable');
        } catch (Exception $e) {
            $response->setStatusCode(500, 'Internal server error');
        }

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
     *
     * @param string $id
     *
     * @return Response
     */
    public function fetchDocumentAction(string $id): Response
    {
        /** @var DocumentService $documentService */
        $documentService = $this->getDI()->get(DocumentService::class);
        $response = new Response();

        try {
            /** @var Document $document */
            $document = $documentService->fetchDocument(self::OWNER_ID, $id);
            $response->setJsonContent(ApiResponse::buildFromEntity($document));
        } catch (DocumentNotFoundException $ne) {
            $response->setStatusCode(404, 'Not found');
        } catch (LogicException $le) {
            $response->setStatusCode(503, 'Service unavailable');
        } catch (Exception $e) {
            $response->setStatusCode(500, 'Internal server error');
        }

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
        /** @var DocumentService $documentService */
        $documentService = $this->getDI()->get(DocumentService::class);

        /** @var Document $document */
        $document = $documentService->createDocument(self::OWNER_ID, null);

        $response = new Response();
        $response->setStatusCode(201, 'Created');
        $response->setJsonContent(ApiResponse::buildFromEntity($document));

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
     *
     * @param string $id
     *
     * @return Response
     */
    public function updateDocumentAction(string $id): Response
    {
        /** @var DocumentService $documentService */
        $documentService = $this->getDI()->get(DocumentService::class);
        $response = new Response();

        $rawData = $this->request->getJsonRawBody(true);
        $requestValidator = new UpdateRequestValidator();
        if (!$requestValidator->isValid($rawData)) {
            $response->setStatusCode(400, 'Bad request');

            return  $response;
        }

        $request = ApiRequest::buildFromRequest($rawData['document']);

        try {
            /** @var Document $document */
            $document = $documentService->updateDocument(self::OWNER_ID, $id, $request->document->payload);
            $response->setJsonContent(ApiResponse::buildFromEntity($document));
        } catch (DocumentNotFoundException $ne) {
            $response->setStatusCode(404, 'Not found');
        } catch (LogicException $le) {
            $response->setStatusCode(503, 'Service unavailable');
        } catch (Exception $e) {
            $response->setStatusCode(500, 'Internal server error');
        }

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
     *
     * @param string $id
     *
     * @return Response
     */
    public function publishDocumentAction(string $id): Response
    {
        /** @var DocumentService $documentService */
        $documentService = $this->getDI()->get(DocumentService::class);
        $response = new Response();
        try {
            /** @var Document $document */
            $document = $documentService->publishDocument(self::OWNER_ID, $id);
            $response->setJsonContent(ApiResponse::buildFromEntity($document));
        } catch (DocumentNotFoundException $ne) {
            $response->setStatusCode(404, 'Not found');
        } catch (LogicException $le) {
            $response->setStatusCode(503, 'Service unavailable');
        } catch (Exception $e) {
            $response->setStatusCode(500, 'Internal server error');
        }

        return $response;
    }
}
