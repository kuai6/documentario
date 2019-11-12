<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application;

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

        return $router;
    });

    /**
     * Handle the request.
     */
    $application = new Application($di);
    $application->useImplicitView(false);
    echo $application->handle()->getContent();
} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
