<?php

namespace Tests\Feature\core\application\category;

use App\Models\Category as CategoryModel;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use core\application\category\UpdateCategoryUseCase;
use core\application\dto\category\UpdateCategoryInputDTO;
use Tests\TestCase;

class UpdateCategoryUseCaseTest extends TestCase {

    public function test_update(): void {
        $repository = new CategoryEloquentRepository(new CategoryModel());
        $useCase = new UpdateCategoryUseCase($repository);
        $categoryDb = CategoryModel::factory()->create();

        $response = $useCase->execute(new UpdateCategoryInputDTO(
            id: $categoryDb->id,
            name: 'Category Updated'
        ));

        $this->assertEquals($categoryDb->id, $response->id);
        $this->assertEquals('Category Updated', $response->name);
        $this->assertEquals($categoryDb->description, $response->description);
        $this->assertDatabaseHas('categories', [
            'id' => $categoryDb->id,
            'name' => 'Category Updated'
        ]);
    }
}
