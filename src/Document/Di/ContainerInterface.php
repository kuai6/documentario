<?php

declare(strict_types=1);

namespace Document\Di;

/**
 * Interface ContainerInterface.
 */
interface ContainerInterface
{
    /**
     * @param string $alias
     *
     * @return mixed
     */
    public function get(string $alias);
}
