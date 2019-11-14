<?php

declare(strict_types=1);

namespace Application\Controller;

use Phalcon\Mvc\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     description="This service provide simple api to store and edit json documents",
 *     version="1.0.0",
 *     title="Documentario",
 *     @OA\Contact(
 *         email="kuai6@ya.ru"
 *     )
 * )
 * @OA\Server(
 *     url="http://127.0.0.1:1080/api/v1",
 *     description="api"
 * )
 *
 *
 * Class Base
 */
class Base extends Controller
{
}
