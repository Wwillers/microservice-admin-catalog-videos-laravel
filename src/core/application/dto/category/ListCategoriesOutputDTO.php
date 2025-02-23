<?php

namespace core\application\dto\category;

class ListCategoriesOutputDTO {

    public function __construct(
        public array $items,
        public int   $total,
        public int   $first_page,
        public int   $last_page,
        public int   $current_page,
        public int   $per_page,
        public int   $to,
        public int   $from,
    ) {
    }
}
