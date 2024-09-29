<?php

namespace core\domain\validation;

use core\domain\exception\EntityValidationException;

class DomainValidation {

    public static function notNull(string $value, string $exceptionMessage = null): void {
        if (empty($value))
            throw new EntityValidationException($exceptionMessage ?? 'Value is required');
    }

    public static function strMaxLength(string $value, int $maxLength = 255, string $exceptionMessage = null): void {
        if (strlen($value) > $maxLength)
            throw new EntityValidationException($exceptionMessage ?? "Value exceeds the maximum length of {$maxLength} characters");
    }

    public static function strMinLength(string $value, int $minLength = 3, string $exceptionMessage = null): void {
        if (strlen($value) < $minLength)
            throw new EntityValidationException($exceptionMessage ?? "Value must have at least {$minLength} characters");
    }

    public static function strCanBeNullAndMaxLength(string $value = '', int $maxLength = 255, string $exceptionMessage = null): void {
        if (!empty($value) && strlen($value) > $maxLength)
            throw new EntityValidationException($exceptionMessage ?? "Value exceeds the maximum length of {$maxLength} characters");
    }
}
