<?php

namespace Tests\Unit\App\Http\Controllers;

use App\Http\Controllers\CategoryController;
use core\application\category\ListCategoriesUseCase;
use core\application\dto\category\ListCategoriesOutputDTO;
use Illuminate\Http\Request;
use Mockery;
use PHPUnit\Framework\TestCase;

class CategoryControllerUnitTest extends TestCase {

    public function testIndex(): void {
        $mockRequest = Mockery::mock(Request::class);
        $mockRequest->shouldReceive('get')
            ->andReturn('1');
        $mockUseCase = Mockery::mock(ListCategoriesUseCase::class);
        $mockUseCase->shouldReceive('execute')
            ->andReturn($this->createListCategoriesOutputDTO());
        $controller = new CategoryController();

        $response = $controller->index($mockRequest, $mockUseCase);

        $this->assertIsObject($response->resource);
        $this->assertArrayHasKey('meta', $response->additional);
    }

    private function createListCategoriesOutputDTO(): ListCategoriesOutputDTO {
        return new ListCategoriesOutputDTO(
            items: [], total: 1, first_page: 1, last_page: 1, current_page: 1, per_page: 1, to: 1, from: 1
        );
    }

    protected function tearDown(): void {
        parent::tearDown();
        Mockery::close();
    }
}
