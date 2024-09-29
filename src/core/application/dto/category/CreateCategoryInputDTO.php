<?php

namespace core\application\dto\category;

class CreateCategoryInputDTO {

    public function __construct(
        public string $name,
        public string $description = '',
    ) {
    }
}
