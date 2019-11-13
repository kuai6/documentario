<?php

declare(strict_types=1);

namespace Application\Di;

use Document\Di\ContainerInterface;
use Phalcon\Di;

/**
 * Class Container.
 */
class Container implements ContainerInterface
{
    /**
     * @var Di
     */
    private $di;

    /**
     * Container constructor.
     *
     * @param Di $di
     */
    public function __construct(Di $di)
    {
        $this->di = $di;
    }

    /**
     * @param string $alias
     *
     * @return mixed
     */
    public function get(string $alias)
    {
        return $this->di->get($alias);
    }
}
