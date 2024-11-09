<?php

namespace App\Http\Controllers\Api\V1\Category;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ApiController;
use App\Http\Requests\CategoryRequest;

class CategoryController extends ApiController
{
    public function index(): JsonResponse
    {
        $categories = Category::all();

        return $this->showAll($categories, 200);
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return $this->showOne($category, 201);
    }

    public function show(Category $category): JsonResponse
    {
        return $this->showOne($category, 200);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return $this->showOne($category, 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return $this->infoResponse('category deleted', 200);
    }
}
