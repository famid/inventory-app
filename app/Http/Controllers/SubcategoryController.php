<?php

namespace App\Http\Controllers;

use App\Http\Services\Subcategory\SubcategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class SubcategoryController extends Controller {

    /**
     * @var SubcategoryService
     */
    private SubcategoryService $subcategoryService;

    /**
     * @param SubcategoryService $subcategoryService
     */
    public function __construct(SubcategoryService $subcategoryService) {
        $this->subcategoryService = $subcategoryService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getList(Request $request): JsonResponse {
        return response()->json(
            $this->subcategoryService->getSubcategories($request->query())
        );
    }
}
