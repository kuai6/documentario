<?php

use Application\Di\Container;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Document\Di\Repository\DocumentRepositoryFactory;
use Document\Di\Service\DocumentServiceFactory;
use Document\Repository\DocumentRepository;
use Document\Service\DocumentService;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Dispatcher;

chdir(dirname(__DIR__));
error_reporting(E_ALL);

try {
    include './vendor/autoload.php';

    $config = require __DIR__ . '/../config/application.config.php';

    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

    /*
     * Shared configuration service
     */
    $di->setShared('config', $config);

    /*
     * Register router
     */
    $di->setShared('router', function () {
        $router = new Phalcon\Mvc\Router\Annotations();
        $router->setUriSource(
            Phalcon\Mvc\Router\Annotations::URI_SOURCE_SERVER_REQUEST_URI
        );
        $router->addResource('Application\Controller\Index');
        $router->addResource('Application\Controller\Document');
        $router->addResource('Application\Controller\Error');

        return $router;
    });

    $di->set(
        'dispatcher',
        function () use ($di) {
            $evManager = $di->getShared('eventsManager');

            $evManager->attach(
                'dispatch:beforeException',
                /**
                 * @return bool|null
                 *
                 * @var Dispatcher
                 */
                function ($event, $dispatcher, $exception) {
                    switch ($exception->getCode()) {
                        case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                        case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                            $dispatcher->forward(
                                [
                                    'controller' => 'Application\Controller\Error',
                                    'action'     => 'http404',
                                ]
                            );

                            return false;
                    }

                    return null;
                }
            );
            $dispatcher = new Dispatcher();
            $dispatcher->setEventsManager($evManager);

            return $dispatcher;
        },
        true
    );

    $container = new Container($di);
    $di->set('container', $container);

    $di->set(Connection::class, DriverManager::getConnection($config->database->toArray()));

    $di->set(DocumentRepository::class, function () use ($container) {
        $factory = new DocumentRepositoryFactory();

        return $factory->create($container);
    });

    $di->set(DocumentService::class, function () use ($container) {
        $factory = new DocumentServiceFactory();

        return $factory->create($container);
    });

    /**
     * Handle the request.
     */
    $application = new Application($di);
    $application->useImplicitView(false);
    $response = $application->handle();
    $response->send();
} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
