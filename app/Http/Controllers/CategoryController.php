<?php

namespace App\Http\Controllers;

use App\Http\Services\Category\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller {

    /**
     * @var CategoryService
     */
    private CategoryService $categoryService;

    /**
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }

    /**
     * @return JsonResponse
     */
    public function getList(): JsonResponse {
        return response()->json(
            $this->categoryService->getAllCategory()
        );
    }
}
