<?php

namespace core\application\category;

use core\application\dto\category\ListCategoriesInputDTO;
use core\application\dto\category\ListCategoriesOutputDTO;
use core\domain\repository\CategoryRepository;

class ListCategoriesUseCase {

    protected CategoryRepository $repository;

    public function __construct(CategoryRepository $repository) {
        $this->repository = $repository;
    }

    public function execute(ListCategoriesInputDTO $input): ListCategoriesOutputDTO {

        $categories = $this->repository->paginate(
            filter: $input->filter,
            order: $input->order,
            page: $input->page,
            totalPage: $input->totalPage
        );

        return new ListCategoriesOutputDTO(
            items: $categories->items(),
            total: $categories->totalItems(),
            first_page: $categories->firstPage(),
            last_page: $categories->lastPage(),
            current_page: $categories->currentPage(),
            per_page: $categories->perPage(),
            to: $categories->to(),
            from: $categories->from()
        );
    }
}
