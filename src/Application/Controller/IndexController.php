<?php

declare(strict_types=1);

namespace Application\Controller;

use Phalcon\Annotations\Annotation as Get;
use Phalcon\Annotations\Annotation as Post;
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
    public function indexAction(): Response
    {
        $response = new Response();
        $response->setJsonContent(['haha']);

        return $response;
    }

    /**
     * @Post(
     *     '/login'
     * )
     */
    public function loginAction(): Response
    {
        $response = new Response();
        $response->setJsonContent(['login']);

        return $response;
    }
}
