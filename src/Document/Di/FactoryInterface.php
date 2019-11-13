<?php

namespace Document\Di;

/**
 * Interface FactoryInterface.
 */
interface FactoryInterface
{
    /**
     * @param ContainerInterface $container
     *
     * @return mixed
     */
    public function create(ContainerInterface $container);
}
