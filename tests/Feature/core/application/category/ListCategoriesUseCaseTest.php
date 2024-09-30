<?php

namespace Tests\Feature\core\application\category;

use App\Models\Category as CategoryModel;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use core\application\category\ListCategoriesUseCase;
use core\application\dto\category\ListCategoriesInputDTO;
use Tests\TestCase;

class ListCategoriesUseCaseTest extends TestCase {

    public function test_list_empty(): void {
        $useCase = $this->createUseCase();

        $response = $useCase->execute(new ListCategoriesInputDTO());

        $this->assertCount(0, $response->items);
    }

    private function createUseCase(): ListCategoriesUseCase {
        $repository = new CategoryEloquentRepository(new CategoryModel());
        return new ListCategoriesUseCase($repository);
    }

    public function test_list_all(): void {
        $useCase = $this->createUseCase();
        $categoriesDb = CategoryModel::factory()->count(20)->create();

        $response = $useCase->execute(new ListCategoriesInputDTO());

        $this->assertEquals(20, $response->total);
        $this->assertCount(15, $response->items);
    }
}
