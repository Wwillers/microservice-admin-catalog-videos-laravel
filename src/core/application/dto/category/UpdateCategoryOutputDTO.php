<?php

namespace core\application\dto\category;

class UpdateCategoryOutputDTO {

    public function __construct(
        public string  $id,
        public string  $name,
        public ?string $description = null,
        public bool    $isActive = true,
        public string  $created_at = '',
    ) {
    }
}
