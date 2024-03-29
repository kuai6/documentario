<?php

declare(strict_types=1);

namespace Application\Controller;

use Phalcon\Http\Response;

/**
 * Class ErrorController.
 */
class ErrorController extends Base
{
    public function http404Action(): Response
    {
        $response = new Response();
        $response->setStatusCode(404, 'Not Found');

        return $response;
    }
}
