<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\ProductCategoryService;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function __construct(
        ProductCategoryService $PCService
    ) {
        $this->PCService = $PCService;
    }

    public function getAll (Request $request)
    {
        $service = $this->PCService->getAll($request);
        return $service;
    }

    public function store (Request $request)
    {
        $service = $this->PCService->store($request);
        return $service;
    }

    public function update (Request $request, $id)
    {
        $service = $this->PCService->update($request, $id);
        return $service;
    }

    public function destroy ($id)
    {
        $service = $this->PCService->destroy($id);
        return $service;
    }

    public function getOne ($id)
    {
        $service = $this->PCService->getOne($id);
        return $service;
    }
}
