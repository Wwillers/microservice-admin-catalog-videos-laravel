<?php

namespace Tests\Unit\application\category;

use core\application\category\ListCategoriesUseCase;
use core\application\dto\category\ListCategoriesInputDTO;
use core\application\dto\category\ListCategoriesOutputDTO;
use core\domain\repository\CategoryRepository;
use core\domain\repository\Pagination;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class ListCategoriesUnitTest extends TestCase {

    public function testListCategoriesEmpty() {
        $mockPagination = $this->mockPagination();
        $mockRepository = Mockery::mock(stdClass::class, CategoryRepository::class);
        $mockRepository->shouldReceive('paginate')
            ->once()
            ->with('id', 'asc', 1, 10)
            ->andReturn($mockPagination);
        $useCase = new ListCategoriesUseCase($mockRepository);
        $listCategoriesDTO = $this->createListCategoriesDTO();

        $response = $useCase->execute($listCategoriesDTO);

        $this->assertInstanceOf(ListCategoriesOutputDTO::class, $response);
        $this->assertCount(0, $response->items);
    }

    private function mockPagination(array $items = []): Pagination {
        $mockPagination = Mockery::mock(stdClass::class, Pagination::class);
        $mockPagination->shouldReceive('items')->andReturn($items);
        $mockPagination->shouldReceive('totalItems')->andReturn(0);
        $mockPagination->shouldReceive('firstPage')->andReturn(1);
        $mockPagination->shouldReceive('lastPage')->andReturn(1);
        $mockPagination->shouldReceive('currentPage')->andReturn(1);
        $mockPagination->shouldReceive('perPage')->andReturn(10);
        $mockPagination->shouldReceive('to')->andReturn(0);
        $mockPagination->shouldReceive('from')->andReturn(0);

        return $mockPagination;
    }

    private function createListCategoriesDTO(): ListCategoriesInputDTO {
        return new ListCategoriesInputDTO("id", "asc", 1, 10);
    }

    public function testListCategories() {
        $register = new stdClass();
        $register->id = "id";
        $register->name = "Category Name";
        $register->description = "Category Description";
        $register->is_active = true;
        $register->created_at = "2021-01-01 00:00:00";
        $register->updated_at = "2021-01-01 00:00:00";
        $register->deleted_at = "2021-01-02 00:00:00";
        $mockPagination = $this->mockPagination([
            $register
        ]);
        $mockRepository = Mockery::mock(stdClass::class, CategoryRepository::class);
        $mockRepository->shouldReceive('paginate')
            ->once()
            ->with('id', 'asc', 1, 10)
            ->andReturn($mockPagination);
        $useCase = new ListCategoriesUseCase($mockRepository);
        $listCategoriesDTO = $this->createListCategoriesDTO();

        $response = $useCase->execute($listCategoriesDTO);

        $this->assertInstanceOf(ListCategoriesOutputDTO::class, $response);
        $this->assertInstanceOf(stdClass::class, $response->items[0]);
        $this->assertCount(1, $response->items);
    }

    protected function tearDown(): void {
        Mockery::close();
        parent::tearDown();
    }
}
