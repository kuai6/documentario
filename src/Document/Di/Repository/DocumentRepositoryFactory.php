<?php

namespace Document\Di\Repository;

use Doctrine\DBAL\Connection;
use Document\Di\ContainerInterface;
use Document\Di\FactoryInterface;
use Document\Repository\DocumentRepository;

class DocumentRepositoryFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     *
     * @return mixed
     */
    public function create(ContainerInterface $container)
    {
        /** @var Connection $connection */
        $connection = $container->get(Connection::class);

        return new DocumentRepository($connection);
    }
}
