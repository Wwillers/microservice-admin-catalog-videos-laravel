<?php

namespace Tests\Feature\core\application\category;

use App\Models\Category as CategoryModel;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use core\application\category\ListCategoryUseCase;
use core\application\dto\category\ListCategoryInputDTO;
use Tests\TestCase;

class ListCategoryUseCaseTest extends TestCase {

    public function test_list(): void {
        $repository = new CategoryEloquentRepository(new CategoryModel());
        $useCase = new ListCategoryUseCase($repository);
        $categoryDb = CategoryModel::factory()->create();

        $response = $useCase->execute(new ListCategoryInputDTO($categoryDb->id));

        $this->assertEquals($categoryDb->id, $response->id);
        $this->assertEquals($categoryDb->name, $response->name);
        $this->assertEquals($categoryDb->description, $response->description);
        $this->assertEquals($categoryDb->is_active, $response->is_active);
    }
}
