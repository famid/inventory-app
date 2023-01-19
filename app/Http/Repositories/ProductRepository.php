<?php

namespace App\Http\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository  {

    /**
     * ProductRepository constructor.
     * @param Product $product
     */
    public function __construct(Product $product) {
        parent::__construct($product);
    }

    /**
     * @return mixed
     */
    private function getProducts(): mixed {
        return $this->model::query()->with(['category', 'subcategory']);
    }

    /**
     * @param $queries
     * @return mixed
     */
    public function productTableDataQuery($queries) {
        $dbQuery = $this->getProducts();

        if (array_key_exists('category_id', $queries)) {
            $dbQuery = $dbQuery->where('category_id', $queries['category_id']);
        }
        if (array_key_exists('subcategory_id', $queries)) {
            $dbQuery = $dbQuery->where('subcategory_id', $queries['subcategory_id']);
        }
        if (array_key_exists('title', $queries)) {
            $dbQuery = $dbQuery->where('title', 'like' , '%'.$queries['title'].'%');
        }
        if (array_key_exists('min_price', $queries)) {
            $dbQuery = $dbQuery->where('price', '>=' , $queries['min_price']);
        }
        if (array_key_exists('max_price', $queries)) {
            $dbQuery = $dbQuery->where('price', '<=' , $queries['max_price']);
        }

        return $dbQuery->get();
    }
}
