<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Services\Product\ProductService;
use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ProductController extends Controller {

    /**
     * @var ProductService
     */
    private ProductService $productService;

    /**
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    /**
     * @return Factory|View|Application
     */
    public function create(): Factory|View|Application {
        $category['categories'] = Category::all();
        return view('product.create', $category);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getList(Request $request): JsonResponse {
        return response()->json(
            $this->productService->getList($request->query())
        );
    }

    /**
     * @param StoreProductRequest $request
     * @return JsonResponse
     */
    public function store(StoreProductRequest $request): JsonResponse {
        return response()->json(
            $this->productService->createProduct($request)
        );
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse {
        return response()->json(
            $this->productService->deleteProduct($id)
        );
    }
}
