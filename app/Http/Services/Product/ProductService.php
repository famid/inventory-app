<?php

namespace App\Http\Services\Product;

use App\Http\Services\Boilerplate\BaseService;
use App\Http\Repositories\ProductRepository;
use Illuminate\Database\QueryException;


class ProductService extends BaseService {

    /**
     * ProductService constructor.
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository) {
        $this->repository = $productRepository;
    }

    /**
     * @param $request
     * @return array
     */
    public function createProduct(object $request) :array {
        try {
            $createProductResponse = $this->repository->create(
                $this->preparedCreateProductData($request)
            );

            return !$createProductResponse ?
                $this->response()->error() :
                $this->response()->success('Product is created successfully');
        } catch(QueryException $e) {

            return $this->response()->error($e->getMessage());
        }
    }

    /**
     * @param object $request
     * @return array
     */
    private function preparedCreateProductData (object $request) :array {
        return [
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'title' => $request->title,
            'description' => isset($request->description) ? $request->description : null,
            'price' => $request->price,
            'thumbnail' => $this->storeThumbnail($request->thumbnail),
        ];
    }

    private function storeThumbnail($file): string {
        $destinationPath = "products/thumbnails/";
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/'.$destinationPath, $fileName);
        $fileName = 'storage/'.$destinationPath.$fileName;
        return $fileName;
    }

    /**
     * @param $id
     * @return array
     */
    public function deleteProduct(int $id) :array {
        try{
            $deleteProductResponse = $this->repository->deleteWhere(
                ['id' => $id]
            );
            return $deleteProductResponse <= 0 ?
                $this->response()->error() :
                $this->response()->success('Product is deleted successfully');
        } catch(QueryException $e) {

            return $this->response()->error();
        }
    }

    public function getList(array $queries)
    {
        try {
            $getAllProducts = $this->repository->productTableDataQuery($queries);

            return $this->response($getAllProducts)->success();
        } catch (QueryException $e) {

            return $this->response()->error($e->getMessage());
        }
    }
}
