<?php

namespace core\application\category;

use core\application\dto\category\UpdateCategoryInputDTO;
use core\application\dto\category\UpdateCategoryOutputDTO;
use core\domain\repository\CategoryRepository;

class UpdateCategoryUseCase {

    protected CategoryRepository $repository;

    public function __construct(CategoryRepository $repository) {
        $this->repository = $repository;
    }

    public function execute(UpdateCategoryInputDTO $input): UpdateCategoryOutputDTO {
        $category = $this->repository->findById($input->id);
        $category->update(
            name: $input->name,
            description: $input->description ?? $category->description
        );
        $updatedCategory = $this->repository->update($category);
        return new UpdateCategoryOutputDTO(
            id: $updatedCategory->id,
            name: $updatedCategory->name,
            description: $updatedCategory->description,
            isActive: $updatedCategory->isActive,
            created_at: $updatedCategory->createdAt()
        );
    }
}
