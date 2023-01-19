<?php

namespace App\Http\Repositories;

use App\Models\Category;

class CategoryRepository extends BaseRepository  {

    /**
     * CategoryRepository constructor.
     * @param Category $categorie
     */
    public function __construct(Category $categorie) {
        parent::__construct($categorie);
    }

    /**
     * @param $where
     * @return mixed
     */
    public function getCategory($where) {
        return $this->model->where($where)->orderBy('id', 'ASC')->first();
    }
}
