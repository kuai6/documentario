<?php

declare(strict_types=1);

namespace Application\Controller;

use Phalcon\Annotations\Annotation as Get;
use Phalcon\Http\Response;

/**
 * @RoutePrefix('/api/v1')
 *
 * Class Index
 */
class IndexController extends Base
{
    /**
     * @Get(
     *     '/'
     * )
     */
    public function indexAction()
    {
        $response = new Response();
        $response->setJsonContent(['haha']);

        return $response;
    }

    /**
     * @Get(
     *     '/document'
     * )
     */
    public function documentAction()
    {
        $response = new Response();
        $response->setJsonContent(['haha2']);

        return $response;
    }
}
