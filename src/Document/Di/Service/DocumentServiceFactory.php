<?php

declare(strict_types=1);

namespace Document\Di\Service;

use Document\Di\ContainerInterface;
use Document\Di\FactoryInterface;
use Document\DocumentRepositoryInterface;
use Document\Repository\DocumentRepository;
use Document\Service\DocumentService;
use Psr\Log\LoggerInterface;

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
        /** @var DocumentRepositoryInterface $repository */
        $repository = $container->get(DocumentRepository::class);

        /** @var LoggerInterface $logger */
        $logger = $container->get(LoggerInterface::class);

        return new DocumentService($repository, $logger);
    }
}
