<?php

namespace Tests\Unit\application\category;

use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use core\application\category\UpdateCategoryUseCase;
use core\application\dto\category\UpdateCategoryInputDTO;
use core\application\dto\category\UpdateCategoryOutputDTO;
use core\domain\entity\Category;
use core\domain\repository\CategoryRepository;
use stdClass;

class UpdateCategoryUnitTest extends TestCase {

    public function testRenameCategory() {
        $uuid = Uuid::uuid4()->toString();
        $mockCategoryEntity = Mockery::mock(Category::class, [
            $uuid, 'Category Name', 'Category Description'])->makePartial();

        $mockRepository = Mockery::spy(stdClass::class, CategoryRepository::class);
        $mockRepository->shouldReceive('findById')
            ->once()
            ->with($uuid)
            ->andReturn($mockCategoryEntity);
        $mockRepository->shouldReceive('update')
            ->with(Mockery::capture($category))
            ->andReturn($mockCategoryEntity);
        $useCase = new UpdateCategoryUseCase($mockRepository);

        $response = $useCase->execute($this->createUpdateCategoryDTO($uuid));

        $this->assertInstanceOf(UpdateCategoryOutputDTO::class, $response);
        $this->assertEquals('New Category Name', $category->name);
        $this->assertEquals('Category Description', $category->description);
        $this->assertEquals($uuid, $category->id);
    }

    protected function tearDown(): void {
        Mockery::close();
        parent::tearDown();
    }

    private function createUpdateCategoryDTO(string $uuid): UpdateCategoryInputDTO {
        return new UpdateCategoryInputDTO(
            id: $uuid,
            name: 'New Category Name',
        );
    }
}
