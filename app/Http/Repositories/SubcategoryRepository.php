<?php

namespace App\Http\Repositories;

use App\Models\Subcategory;

class SubcategoryRepository extends BaseRepository  {

    /**
     * SubcategoryRepository constructor.
     * @param Subcategory $subcategories
     */
    public function __construct(Subcategory $subcategories) {
        parent::__construct($subcategories);
    }

    /**
     * @return mixed
     */
    private function getSubcategories(): mixed {
        return $this->model->query();
    }

    public function allSubcategories(array $queries) {
        $dbQuery = $this->getSubcategories();

        if (array_key_exists('category_id', $queries)) {
            $dbQuery = $dbQuery->where('category_id', $queries['category_id']);
        }

        return $dbQuery->get();
    }
}
