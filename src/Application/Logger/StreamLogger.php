<?php

declare(strict_types=1);

namespace Application\Logger;

use Phalcon\Logger\Adapter\Stream;
use Psr\Log\LoggerInterface;

/**
 * Class StreamLogger.
 */
class StreamLogger extends Stream implements LoggerInterface
{
}
