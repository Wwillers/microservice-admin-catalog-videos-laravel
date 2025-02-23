<?php

namespace core\domain\repository;

use core\domain\entity\Category;

interface CategoryRepository {

    public function insert(Category $category): Category;

    public function findById(string $id): Category;

    public function findAll(string $filter = '', $order = 'DESC'): array;

    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPage = 15): Pagination;

    public function update(Category $category): Category;

    public function delete(string $id): bool;
}
