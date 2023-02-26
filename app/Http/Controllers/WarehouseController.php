<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyWarehouseRequest;
use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Services\Warehouse\WarehouseService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * @var WarehouseService
     */
    private WarehouseService $warehouseService;

    /**
     * @param WarehouseService $warehouseService
     */
    public function __construct(WarehouseService $warehouseService) {
        $this->warehouseService = $warehouseService;
    }
    /**
     * @return Factory|View|Application
     */
    public function index(): View|Factory|Application
    {
        return view('warehouse.pagination');
    }

    public function getList(Request $request): JsonResponse
    {
        $warehouseResponse = $this->warehouseService->getList($request->query());
        if (!$warehouseResponse['success']) {
            return response()->json(['error' => $warehouseResponse['message']], 500);
        }
        return response()->json($warehouseResponse);
    }

    public function destroy(DestroyWarehouseRequest $request) {

    }

    public function create() {
        return view('warehouse.create');
    }

    public function store(StoreWarehouseRequest $request) {

    }
}
