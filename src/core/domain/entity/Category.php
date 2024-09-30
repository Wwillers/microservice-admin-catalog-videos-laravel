<?php

namespace core\domain\entity;

use core\domain\entity\traits\MagicMethodsTrait;
use core\domain\validation\DomainValidation;
use core\domain\valueObject\Uuid;
use DateTime;

class Category {

    use MagicMethodsTrait;

    public function __construct(
        protected Uuid|string     $id = '',
        protected string          $name = '',
        protected string          $description = '',
        protected bool            $isActive = true,
        protected DateTime|string $createdAt = '',
    ) {
        $this->id = $this->id
            ? new Uuid($this->id)
            : Uuid::generate();
        $this->createdAt = $this->createdAt
            ? new DateTime($this->createdAt)
            : new DateTime();
        $this->validate();
    }

    private function validate(): void {
        DomainValidation::strMaxLength($this->name);
        DomainValidation::strMinLength($this->name);
        DomainValidation::strCanBeNullAndMaxLength($this->description);
    }

    public function activate(): void {
        $this->isActive = true;
    }

    public function disable(): void {
        $this->isActive = false;
    }

    public function update(string $name, string $description = ''): void {
        $this->name = $name;
        $this->description = $description;
    }
}
