<?php

namespace Tests\Feature\core\application\category;

use App\Models\Category as CategoryModel;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use core\application\category\DeleteCategoryUseCase;
use core\application\dto\category\DeleteCategoryInputDTO;
use Tests\TestCase;

class DeleteCategoryUseCaseTest extends TestCase {

    public function test_delete(): void {
        $repository = new CategoryEloquentRepository(new CategoryModel());
        $useCase = new DeleteCategoryUseCase($repository);
        $categoryDb = CategoryModel::factory()->create();

        $response = $useCase->execute(new DeleteCategoryInputDTO($categoryDb->id));

        $this->assertTrue($response->success);
        $this->assertSoftDeleted($categoryDb);
    }
}
