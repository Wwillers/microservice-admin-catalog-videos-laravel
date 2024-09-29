<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use core\domain\entity\Category;
use core\domain\entity\Category as EntityCategory;
use core\domain\exception\NotFoundException;
use core\domain\repository\CategoryRepository;
use core\domain\repository\Pagination;
use Tests\TestCase;

class CategoryEloquentRepositoryTest extends TestCase {

    protected CategoryRepository $repository;

    public function testInsert(): void {
        $entity = new EntityCategory(
            name: 'Category Test',
        );

        $response = $this->repository->insert($entity);

        $this->assertInstanceOf(CategoryRepository::class, $this->repository);
        $this->assertInstanceOf(EntityCategory::class, $response);
        $this->assertDatabaseHas('categories', ['name' => 'Category Test']);
    }

    public function testFindById() {
        $category = Model::factory()->create();

        $response = $this->repository->findById($category->id);

        $this->assertInstanceOf(EntityCategory::class, $response);
        $this->assertEquals($category->id, $response->id());
    }

    public function testFindByIdNotFound() {
        $this->expectExceptionMessage('Category with id invalid-id not found');
        $this->expectException(NotFoundException::class);
        $this->repository->findById('invalid-id');
    }

    public function testFindAll() {
        Model::factory()->count(5)->create();
        $response = $this->repository->findAll();
        $this->assertIsArray($response);
        $this->assertCount(5, $response);
    }

    public function testPaginate() {
        Model::factory()->count(20)->create();
        $response = $this->repository->paginate();
        $this->assertInstanceOf(Pagination::class, $response);
        $this->assertCount(15, $response->items());
        $this->assertEquals(20, $response->totalItems());
        $this->assertEquals(2, $response->lastPage());
    }

    public function testEmptyPaginate() {
        $response = $this->repository->paginate();
        $this->assertCount(0, $response->items());
        $this->assertEquals(0, $response->totalItems());
        $this->assertEquals(1, $response->lastPage());
    }

    public function testUpdateIdNotFound() {
        $this->expectException(NotFoundException::class);
        $this->repository->update(new Category(name: "Category"));
    }

    public function testUpdate() {
        $categoryDb = Model::factory()->create();
        $category = new Category(
            id: $categoryDb->id,
            name: "Updated name"
        );

        $response = $this->repository->update($category);

        $this->assertInstanceOf(EntityCategory::class, $response);
        $this->assertEquals("Updated name", $response->name);
    }

    public function testDeleteIdNotFound() {
        $this->expectException(NotFoundException::class);
        $this->repository->delete('fake_id');
    }

    public function testDelete() {
        $categoryDb = Model::factory()->create();
        $response = $this->repository->delete($categoryDb->id);
        $this->assertTrue($response);
    }

    protected function setUp(): void {
        parent::setUp();
        $this->repository = new CategoryEloquentRepository(new Model());
    }
}
