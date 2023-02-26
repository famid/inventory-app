<?php

namespace App\Http\Repositories;

use App\Models\Warehouse;

class WarehouseRepository extends BaseRepository
{
    public function __construct(Warehouse $warehouse) {
        parent::__construct($warehouse);
    }

    private function getWarehouses(): mixed {
        return $this->model::query();
    }

    /**
     * @param $queries
     * @return mixed
     */
    public function warehouseTableDataQuery($queries): mixed
    {
        $dbQuery = $this->getWarehouses();

        if (array_key_exists('name', $queries)) {
            $dbQuery = $dbQuery->where('name', 'like' , '%'.$queries['name'].'%');
        }

        return $dbQuery->paginate(10);
//        return $dbQuery->get();
    }

}
