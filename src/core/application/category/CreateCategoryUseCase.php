<?php

namespace core\application\category;

use core\application\dto\category\CreateCategoryInputDTO;
use core\application\dto\category\CreateCategoryOutputDTO;
use core\domain\entity\Category;
use core\domain\repository\CategoryRepository;

class CreateCategoryUseCase {

    protected CategoryRepository $repository;

    public function __construct(CategoryRepository $repository) {
        $this->repository = $repository;
    }

    public function execute(CreateCategoryInputDTO $input): CreateCategoryOutputDTO {
        $category = new Category(
            name: $input->name,
            description: $input->description
        );
        $createdCategory = $this->repository->insert($category);
        return new CreateCategoryOutputDTO(
            id: $createdCategory->id(),
            name: $createdCategory->name,
            description: $createdCategory->description,
            created_at: $createdCategory->createdAt()
        );
    }
}
