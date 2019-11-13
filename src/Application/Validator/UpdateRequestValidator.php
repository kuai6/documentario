<?php

declare(strict_types=1);

namespace Application\Validator;

use Application\ValidatorInterface;

/**
 * Class DocumentValidator.
 */
class UpdateRequestValidator implements ValidatorInterface
{
    /**
     * Validate data structure.
     *
     * @param $data
     *
     * @return bool
     */
    public function isValid($data): bool
    {
        if (
            empty($data)
            || !array_key_exists('document', $data)
            || !array_key_exists('payload', $data['document'])
            || empty($data['document']['payload'])
        ) {
            return false;
        }

        return true;
    }
}
