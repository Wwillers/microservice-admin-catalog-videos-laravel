<?php

namespace Tests\Unit\application\category;

use core\application\category\ListCategoryUseCase;
use core\application\dto\category\ListCategoryInputDTO;
use core\application\dto\category\ListCategoryOutputDTO;
use core\domain\entity\Category;
use core\domain\repository\CategoryRepository;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class ListCategoryUnitTest extends TestCase {

    public function testGetById() {
        $uuid = Uuid::uuid4()->toString();
        $mockEntity = Mockery::mock(Category::class, [$uuid, 'Category Name', 'Category Description'])->makePartial();
        $mockRepository = Mockery::spy(stdClass::class, CategoryRepository::class);
        $mockRepository->shouldReceive('findById')
            ->once()
            ->with($uuid)
            ->andReturn($mockEntity);
        $useCase = new ListCategoryUseCase($mockRepository);

        $response = $useCase->execute($this->createListCategoryDTO($uuid));

        $this->assertInstanceOf(ListCategoryOutputDTO::class, $response);
        $this->assertEquals($uuid, $response->id);
        $this->assertEquals('Category Name', $response->name);
        $this->assertEquals('Category Description', $response->description);
    }

    private function createListCategoryDTO(string $uuid): ListCategoryInputDTO {
        return new ListCategoryInputDTO($uuid);
    }

    protected function tearDown(): void {
        Mockery::close();
        parent::tearDown();
    }
}
