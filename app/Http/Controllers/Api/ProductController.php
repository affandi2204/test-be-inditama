<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        ProductService $productService
    ) {
        $this->productService = $productService;
    }

    public function getAll (Request $request)
    {
        $service = $this->productService->getAll($request);
        return $service;
    }

    public function store (Request $request)
    {
        $service = $this->productService->store($request);
        return $service;
    }

    public function update (Request $request, $id)
    {
        $service = $this->productService->update($request, $id);
        return $service;
    }

    public function destroy ($id)
    {
        $service = $this->productService->destroy($id);
        return $service;
    }

    public function getOne ($id)
    {
        $service = $this->productService->getOne($id);
        return $service;
    }
}
