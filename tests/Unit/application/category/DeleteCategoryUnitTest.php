<?php

namespace Tests\Unit\application\category;

use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use core\application\category\DeleteCategoryUseCase;
use core\application\dto\category\DeleteCategoryInputDTO;
use core\application\dto\category\DeleteCategoryOutputDTO;
use core\domain\entity\Category;
use core\domain\repository\CategoryRepository;
use stdClass;

class DeleteCategoryUnitTest extends TestCase {

    public function testDelete() {
        $uuid = Uuid::uuid4()->toString();
        $mockRepository = Mockery::mock(stdClass::class, CategoryRepository::class);
        $mockRepository->shouldReceive('delete')
            ->once()
            ->with($uuid)
            ->andReturn(true);
        $useCase = new DeleteCategoryUseCase($mockRepository);

        $response = $useCase->execute(new DeleteCategoryInputDTO($uuid));

        $this->isInstanceOf(DeleteCategoryOutputDTO::class, $response);
        $this->assertTrue($response->success);
    }

    public function testDeleteFalse() {
        $uuid = Uuid::uuid4()->toString();
        $mockRepository = Mockery::mock(stdClass::class, CategoryRepository::class);
        $mockRepository->shouldReceive('delete')
            ->once()
            ->with($uuid)
            ->andReturn(false);
        $useCase = new DeleteCategoryUseCase($mockRepository);

        $response = $useCase->execute(new DeleteCategoryInputDTO($uuid));

        $this->isInstanceOf(DeleteCategoryOutputDTO::class, $response);
        $this->assertFalse($response->success);
    }

    protected function tearDown(): void {
        Mockery::close();
        parent::tearDown();
    }
}
