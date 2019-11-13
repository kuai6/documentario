<?php

declare(strict_types=1);

namespace Document\Di\Service;

use Document\Di\ContainerInterface;
use Document\Di\FactoryInterface;
use Document\Repository\DocumentRepository;
use Document\Service\DocumentService;

/**
 * Class DocumentServiceFactory.
 */
class DocumentServiceFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     *
     * @return mixed
     */
    public function create(ContainerInterface $container)
    {
        $repository = $container->get(DocumentRepository::class);

        return new DocumentService($repository);
    }
}
