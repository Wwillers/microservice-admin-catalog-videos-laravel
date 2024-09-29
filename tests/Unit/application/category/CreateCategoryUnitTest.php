<?php

namespace Tests\Unit\application\category;

use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use core\application\category\CreateCategoryUseCase;
use core\application\dto\category\CreateCategoryInputDTO;
use core\application\dto\category\CreateCategoryOutputDTO;
use core\domain\entity\Category;
use core\domain\repository\CategoryRepository;
use stdClass;

class CreateCategoryUnitTest extends TestCase {

    public function testCreateNewCategory() {
        $mockRepository = Mockery::mock(stdClass::class, CategoryRepository::class);
        $uuid = Uuid::uuid4()->toString();
        $createCategoryDTO = $this->createCategoryDTO();
        $mockEntity = Mockery::mock(Category::class, [$uuid, $createCategoryDTO->name, $createCategoryDTO->description])->makePartial();
        $mockRepository->shouldReceive('insert')
            ->once()
            ->andReturn($mockEntity);
        $useCase = new CreateCategoryUseCase($mockRepository);

        $categoryCreatedDTO = $useCase->execute($createCategoryDTO);

        $this->assertInstanceOf(CreateCategoryOutputDTO::class, $categoryCreatedDTO);
        $this->assertEquals($uuid, $categoryCreatedDTO->id);
        $this->assertEquals('New Category Name', $categoryCreatedDTO->name);
        $this->assertEquals('New Category Description', $categoryCreatedDTO->description);

        Mockery::close();
    }

    protected function tearDown(): void {
        Mockery::close();
        parent::tearDown();
    }

    private function createCategoryDTO(): CreateCategoryInputDTO {
        return new CreateCategoryInputDTO('New Category Name', 'New Category Description');
    }
}
