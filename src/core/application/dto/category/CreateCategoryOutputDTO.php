<?php

namespace core\application\dto\category;

class CreateCategoryOutputDTO {

    public function __construct(
        public string $id,
        public string $name,
        public string $description = '',
        public string $created_at = '',
    ) {
    }
}
