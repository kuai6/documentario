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
     *
     * @param mixed $data
     *
     * @return bool
     */
    public function isValid($data): bool;
}
