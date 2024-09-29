<?php

namespace core\application\dto\category;

class ListCategoryOutputDTO {

    public function __construct(public string $id,
                                public string $name,
                                public bool   $active,
                                public string $created_at,
                                public string $description = '',
    ) {
    }
}
