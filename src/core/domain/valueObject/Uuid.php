<?php

namespace core\domain\valueObject;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid {

    public function __construct(
        protected string $value
    ) {
        $this->validate();
    }

    public static function generate(): self {
        return new self(RamseyUuid::uuid4()->toString());
    }

    public function __toString(): string {
        return $this->value;
    }

    private function validate(): void {
        if (!RamseyUuid::isValid($this->value))
            throw new InvalidArgumentException(sprintf('Invalid UUID: %s', $this->value));
    }
}
