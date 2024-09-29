<?php

namespace core\application\category;

use core\application\dto\category\DeleteCategoryInputDTO;
use core\application\dto\category\DeleteCategoryOutputDTO;
use core\domain\repository\CategoryRepository;

class DeleteCategoryUseCase {

    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    public function execute(DeleteCategoryInputDTO $input): DeleteCategoryOutputDTO {
        $response = $this->categoryRepository->delete($input->id);
        return new DeleteCategoryOutputDTO(success: $response);
    }
}
