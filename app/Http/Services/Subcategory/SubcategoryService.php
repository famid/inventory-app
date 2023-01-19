<?php

namespace App\Http\Services\Subcategory;

use App\Http\Services\Boilerplate\BaseService;
use App\Http\Repositories\SubcategoryRepository;
use Illuminate\Database\QueryException;

class SubcategoryService extends BaseService {

    /**
     * SubcategoryService constructor.
     * @param SubcategoryRepository $subcategoryRepository
     */
    public function __construct(SubcategoryRepository $subcategoryRepository) {
        $this->repository = $subcategoryRepository;
    }

    /**
     * @param array $queries
     * @return array
     */
    public function getSubcategories (array $queries) :array {
        try {
            $subcategories = $this->repository->allSubcategories($queries);

            return $subcategories->isEmpty() ?
                $this->response()->error('No subcategory was founded') :
                $this->response($subcategories)->success();
        } catch (QueryException $e) {

            return $this->response()->error();
        }
    }
}
