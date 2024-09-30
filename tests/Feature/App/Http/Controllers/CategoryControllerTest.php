<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\CategoryController;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use core\application\category\CreateCategoryUseCase;
use core\application\category\DeleteCategoryUseCase;
use core\application\category\ListCategoriesUseCase;
use core\application\category\ListCategoryUseCase;
use core\application\category\UpdateCategoryUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CategoryControllerTest extends TestCase {

    protected CategoryController $controller;
    protected CategoryEloquentRepository $repository;

    public function testIndex(): void {
        $useCase = new ListCategoriesUseCase($this->repository);

        $response = $this->controller->index(new Request(), $useCase);

        $this->assertInstanceOf(AnonymousResourceCollection::class, $response);
        $this->assertArrayHasKey('meta', $response->additional);
    }

    public function testStore() {
        $useCase = new CreateCategoryUseCase($this->repository);
        $request = new StoreCategoryRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new InputBag([
            'name' => 'Category Test'
        ]));

        $jsonResponse = $this->controller->store($request, $useCase);

        $this->assertInstanceOf(JsonResponse::class, $jsonResponse);
        $this->assertEquals(Response::HTTP_CREATED, $jsonResponse->getStatusCode());
    }

    public function testShow() {
        $categoryDb = Category::factory()->create();
        $response = $this->controller->show(
            useCase: new ListCategoryUseCase($this->repository),
            id: $categoryDb->id);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testUpdate() {
        $categoryDb = Category::factory()->create();
        $request = new UpdateCategoryRequest();
        $request->headers->set('content-type', 'application/json');
        $request->setJson(new InputBag([
            'name' => 'Category Updated'
        ]));

        $response = $this->controller->update(
            useCase: new UpdateCategoryUseCase($this->repository),
            request: $request,
            id: $categoryDb->id
        );

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testDelete() {
        $categoryDb = Category::factory()->create();
        $response = $this->controller->destroy(
            useCase: new DeleteCategoryUseCase($this->repository),
            id: $categoryDb->id
        );

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    protected function setUp(): void {
        parent::setUp();
        $this->repository = new CategoryEloquentRepository(new Category());
        $this->controller = new CategoryController();
    }
}
