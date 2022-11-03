<?php

namespace App\Http\Services;

use App\Http\Requests\ProductCategory\ProductCategoryRequest;
use App\Http\Requests\ProductCategory\UpdateRequest;
use App\Http\Resources\BaseResponse;
use App\Http\Resources\ProductCategoryResponse;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class ProductCategoryService extends BaseResponse
{
    public function getAll(Request $request)
    {
        try {
            $limit = $request->limit ?? 10;
            $sortBy = $request->sortBy ?? 'id';
            $orderBy = $request->orderBy ?? 'desc';

            $productCategory = ProductCategory::orderBy($sortBy, $orderBy)->paginate($limit);

            if (!empty($request->search)) {
                $search = $request->search;
                $productCategory->Where('name', 'LIKE', "%{$search}%");
            }
            return ProductCategoryResponse::collection($productCategory)->response();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError($th->getMessage(), 500);
        }
    }

    public function store (Request $request)
    {
        try {
            $input      = $request;
            $validator  = processRules($input, ProductCategoryRequest::getRules());
            if($validator->fails()) {
                return $this->sendError($validator->errors(), 400);
            }

            DB::beginTransaction();
            $productCategory = ProductCategory::create([
                'name' => $input->name,
            ]);
            DB::commit();
            return $this->sendResponse(new ProductCategoryResponse($productCategory), 'Successed.', 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->sendError($th->getMessage(), 500);
        }
    }

    public function Update (Request $request, $id)
    {
        try {
            $input      = $request;
            $validator  = processRules($input, UpdateRequest::getRules($id));
            if($validator->fails()) {
                return $this->sendError($validator->errors(), 400);
            }

            $productCategory = $this->findbyId($id);
            if (!$productCategory) {
                return $this->sendError('Product category is not found.', 404);
            }
            DB::beginTransaction();
            $productCategory->name = $input->name;
            $productCategory->save();
            DB::commit();

            $productCategory = $this->findbyId($id);
            return $this->sendResponse(new ProductCategoryResponse($productCategory), 'Successed.', 200);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), 500);
        }
    }


    public function destroy ($id)
    {
        try {
            DB::beginTransaction();
            $productCategory = ProductCategory::find($id);
            if (!$productCategory) {
                return $this->sendError('Product category is not found.', 404);
            } else if (count($productCategory->product)) {
                // if related relation data is exist
                return $this->sendError('Product category can`t be destroyed.', 400);
            }

            $productCategory->delete();
            DB::commit();
            return $this->sendResponse(null, 'Succcessed.');
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->sendError($th->getMessage(), 500);
        }
    }

    public function getOne($id)
    {
        try {
            $productCategory = $this->findbyId($id);
            return $this->sendResponse(new ProductCategoryResponse($productCategory), 'Successed.', 200);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), 500);
        }
    }

    public function findbyId($id)
    {
        $productCategory = ProductCategory::where('id', $id)->first();
        return $productCategory;
    }
}
