<?php

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
        function() use ($di) {

            $evManager = $di->getShared('eventsManager');

            $evManager->attach(
                "dispatch:beforeException",
                /**
                 * @var $dispatcher Dispatcher
                 */
                function($event, $dispatcher, $exception)
                {
                    switch ($exception->getCode()) {
                        case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                        case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                            $dispatcher->forward(
                                array(
                                    'controller' => 'Application\Controller\Error',
                                    'action'     => 'http404',
                                )
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
