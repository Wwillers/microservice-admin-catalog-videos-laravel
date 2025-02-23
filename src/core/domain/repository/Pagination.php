<?php

namespace core\domain\repository;

use stdClass;

interface Pagination {

    /**
     * @return stdClass[]
     */
    public function items(): array;

    public function totalItems(): int;

    public function lastPage(): int;

    public function firstPage(): int;

    public function currentPage(): int;

    public function perPage(): int;

    public function to(): int;

    public function from(): int;
}
