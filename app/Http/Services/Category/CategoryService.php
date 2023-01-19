<?php

namespace App\Http\Services\Category;

use App\Http\Services\Boilerplate\BaseService;
use App\Http\Repositories\CategoryRepository;
use Illuminate\Database\QueryException;

class CategoryService extends BaseService {

    /**
     * CategoryService constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository) {
        $this->repository = $categoryRepository;
    }

    /**
     * @return array
     */
    public function getAllCategory () :array {
        try {
            $allCategory = $this->repository->getData();

            return $allCategory->isEmpty() ?
                $this->response()->error('No category was founded') :
                $this->response($allCategory)->success();
        } catch (QueryException $e) {

            return $this->response()->error();
        }
    }
}
