<?php

namespace core\application\dto\category;

class UpdateCategoryInputDTO {

    public function __construct(
        public string  $id,
        public string  $name,
        public ?string $description = null,
        public bool    $isActive = true,
    ) {
    }
}
