<?php

declare(strict_types=1);

namespace Application;

/**
 * Interface ValidatorInterface.
 */
interface ValidatorInterface
{
    /**
     * Validate data structure.
     */
    public function isValid(object $object): bool;
}
