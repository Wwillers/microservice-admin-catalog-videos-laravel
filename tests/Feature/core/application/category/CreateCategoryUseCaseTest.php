<?php

namespace Tests\Feature\core\application\category;

use App\Models\Category as CategoryModel;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use core\application\category\CreateCategoryUseCase;
use core\application\dto\category\CreateCategoryInputDTO;
use Tests\TestCase;

class CreateCategoryUseCaseTest extends TestCase {

    public function test_exec(): void {
        $repository = new CategoryEloquentRepository(new CategoryModel());
        $useCase = new CreateCategoryUseCase($repository);

        $response = $useCase->execute(
            new CreateCategoryInputDTO(
                name: 'Category Test',
                description: 'Category Test Description'
            )
        );

        $this->assertEquals('Category Test', $response->name);
        $this->assertEquals('Category Test Description', $response->description);
        $this->assertNotEmpty($response->id);
        $this->assertNotEmpty($response->created_at);
        $this->assertDatabaseHas('categories', ['name' => 'Category Test', 'id' => $response->id]);
    }
}
