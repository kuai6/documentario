<?php
declare(strict_types=1);

namespace Application\Controller;

use Phalcon\Http\Response;

/**
 * Class ErrorController
 * @package Application\Controller
 */
class ErrorController extends Base
{
    public function http404Action(): Response
    {
        $response = new Response();
        $response->setJsonContent(['404']);

        return $response;
    }
}