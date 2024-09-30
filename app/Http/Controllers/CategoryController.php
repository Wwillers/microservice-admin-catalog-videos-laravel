<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use core\application\category\CreateCategoryUseCase;
use core\application\category\DeleteCategoryUseCase;
use core\application\category\ListCategoriesUseCase;
use core\application\category\ListCategoryUseCase;
use core\application\category\UpdateCategoryUseCase;
use core\application\dto\category\CreateCategoryInputDTO;
use core\application\dto\category\DeleteCategoryInputDTO;
use core\application\dto\category\ListCategoriesInputDTO;
use core\application\dto\category\ListCategoryInputDTO;
use core\application\dto\category\UpdateCategoryInputDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller {

    public function index(Request $request, ListCategoriesUseCase $useCase) {
        $response = $useCase->execute(
            input: new ListCategoriesInputDTO(
                filter: $request->get('filter', ''),
                order: $request->get('order', 'DESC'),
                page: $request->get('page', 1),
                totalPage: $request->get('totalPage', 15)
            )
        );
        return CategoryResource::collection(collect($response->items))
            ->additional([
                'meta' => [
                    'total' => $response->total,
                    'first_page' => $response->first_page,
                    'last_page' => $response->last_page,
                    'current_page' => $response->current_page,
                    'per_page' => $response->per_page,
                    'to' => $response->to,
                    'from' => $response->from
                ]
            ]);
    }

    public function store(StoreCategoryRequest $request, CreateCategoryUseCase $useCase): JsonResponse {
        $response = $useCase->execute(
            input: new CreateCategoryInputDTO(
                name: $request->name,
                description: $request->description ?? ''
            )
        );
        return (new CategoryResource(collect($response)))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ListCategoryUseCase $useCase, string $id): JsonResponse {
        $response = $useCase->execute(new ListCategoryInputDTO(id: $id));
        return (new CategoryResource(collect($response)))
            ->response();
    }

    public function update(UpdateCategoryUseCase $useCase, UpdateCategoryRequest $request, string $id): JsonResponse {
        $response = $useCase->execute(new UpdateCategoryInputDTO(
            id: $id,
            name: $request->name,
            description: $request->description ?? '',
            isActive: $request->is_active ?? true
        ));
        return (new CategoryResource(collect($response)))
            ->response();
    }

    public function destroy(DeleteCategoryUseCase $useCase, string $id) {
        $useCase->execute(new DeleteCategoryInputDTO(id: $id));
        return response()->noContent();
    }
}
