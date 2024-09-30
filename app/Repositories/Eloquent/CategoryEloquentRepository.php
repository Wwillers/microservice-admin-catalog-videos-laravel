<?php

namespace App\Repositories\Eloquent;

use App\Models\Category as CategoryModel;
use App\Repositories\Presenters\PaginationPresenter;
use core\domain\entity\Category as EntityCategory;
use core\domain\exception\NotFoundException;
use core\domain\repository\CategoryRepository;
use core\domain\repository\Pagination;

class CategoryEloquentRepository implements CategoryRepository {

    protected CategoryModel $model;

    public function __construct(CategoryModel $model) {
        $this->model = $model;
    }

    public function insert(EntityCategory $category): EntityCategory {
        $category = $this->model->create([
            'id' => $category->id(),
            'name' => $category->name,
            'description' => $category->description,
            'is_active' => $category->isActive,
            'created_at' => $category->createdAt(),
        ]);
        return $this->toCategory($category);
    }

    public function findById(string $id): EntityCategory {
        $category = $this->model->find($id);
        if (!$category)
            throw new NotFoundException('Category with id ' . $id . ' not found');
        return $this->toCategory($category);
    }

    public function findAll(string $filter = '', $order = 'DESC'): array {
        return $this->model
            ->where(function ($query) use ($filter) {
                if ($filter)
                    $query->where('name', 'like', '%' . $filter . '%');
            })
            ->orderBy('id', $order)
            ->get()
            ->toArray();
    }

    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPage = 15): Pagination {
        $query = $this->model;
        if ($filter)
            $query->where('name', 'like', '%' . $filter . '%');
        $query->orderBy('id', $order);
        $paginator = $query->paginate($totalPage, ['*'], 'page', $page);
        return new PaginationPresenter($paginator);
    }

    public function update(EntityCategory $category): EntityCategory {
        $categoryDb = $this->model->find($category->id());
        if (!$categoryDb)
            throw new NotFoundException("Category with id {$category->id()} not found");
        $categoryDb->update([
            'name' => $category->name,
            'description' => $category->description,
            "is_active" => $category->isActive
        ]);
        $categoryDb->refresh();
        return $this->toCategory($categoryDb);
    }

    public function delete(string $id): bool {
        $categoryDb = $this->model->find($id);
        if (!$categoryDb)
            throw new NotFoundException("Category with id {$id} not found");
        return $categoryDb->delete();
    }

    private function toCategory(object $object): EntityCategory {
        return new EntityCategory(
            id: $object->id,
            name: $object->name,
            description: $object->description,
            isActive: $object->is_active,
            createdAt: $object->created_at
        );
    }
}
