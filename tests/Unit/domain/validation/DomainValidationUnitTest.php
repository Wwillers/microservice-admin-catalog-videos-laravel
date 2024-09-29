<?php

namespace Tests\Unit\domain\validation;

use PHPUnit\Framework\TestCase;
use core\domain\exception\EntityValidationException;
use core\domain\validation\DomainValidation;

class DomainValidationUnitTest extends TestCase {

    public function testNotNull() {
        $value = '';
        $this->expectException(EntityValidationException::class);
        DomainValidation::notNull($value);
    }

    public function testNotNullWithCustomMessage() {
        $value = '';
        $message = 'Custom message';
        $this->expectException(EntityValidationException::class);
        $this->expectExceptionMessage($message);
        DomainValidation::notNull($value, $message);
    }

    public function testStrMaxLength() {
        $value = 'Teste';
        $message = 'Value exceeds the maximum length of 5 characters';
        $this->expectException(EntityValidationException::class);
        $this->expectExceptionMessage($message);
        DomainValidation::strMaxLength($value, 4, $message);
    }

    public function testStrMinLength() {
        $value = 'Teste';
        $message = 'Value must have at least 6 characters';
        $this->expectException(EntityValidationException::class);
        $this->expectExceptionMessage($message);
        DomainValidation::strMinLength($value, 6, $message);
    }

    public function testStrCanBeNullAndMaxLength() {
        $value = 'Teste';
        $message = 'Value exceeds the maximum length of 4 characters';
        $this->expectException(EntityValidationException::class);
        $this->expectExceptionMessage($message);
        DomainValidation::strCanBeNullAndMaxLength($value, 4, $message);
    }
}
