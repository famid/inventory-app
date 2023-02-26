<?php

namespace App\Http\Services\Warehouse;

use App\Http\Repositories\WarehouseRepository;
use App\Http\Services\Boilerplate\BaseService;
use Illuminate\Database\QueryException;

class WarehouseService extends BaseService
{
    public function __construct(WarehouseRepository $repository) {
        $this->repository = $repository;
    }
    public function getList(array|string|null $queries): array
    {
        try {
            $getAllProducts = $this->repository->warehouseTableDataQuery($queries);

            return $this->response($getAllProducts)->success();
        } catch (QueryException $e) {
            return $this->response()->error($e->getMessage());
        }
    }
}
