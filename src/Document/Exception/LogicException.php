<?php

declare(strict_types=1);

namespace Document\Exception;

use Document\LogicExceptionInterface;

/**
 * Class LogicException.
 */
class LogicException extends \LogicException implements LogicExceptionInterface
{
}
