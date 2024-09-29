<?php

namespace core\application\category;

use core\application\dto\category\ListCategoryInputDTO;
use core\application\dto\category\ListCategoryOutputDTO;
use core\domain\repository\CategoryRepository;

class ListCategoryUseCase {

    protected CategoryRepository $repository;

    public function __construct(CategoryRepository $repository) {
        $this->repository = $repository;
    }

    public function execute(ListCategoryInputDTO $input): ListCategoryOutputDTO {
        $category = $this->repository->findById($input->id);
        return new ListCategoryOutputDTO(
            id: $category->id(),
            name: $category->name,
            active: $category->isActive,
            created_at: $category->createdAt(),
            description: $category->description
        );
    }
}
