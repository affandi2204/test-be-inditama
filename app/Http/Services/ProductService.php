<?php

namespace App\Http\Services;

use App\Http\Requests\Product\ProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\BaseResponse;
use App\Http\Resources\ProductResponse;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductService extends BaseResponse
{
    public function getAll(Request $request)
    {
        try {
            $limit = $request->limit ?? 10;
            $sortBy = $request->sort_by ?? 'id';
            $orderBy = $request->order_by ?? 'desc';
            $search = $request->search;
            $productCategoryId = $request->product_category_id;

            $product = Product::with('productCategory')->orderBy($sortBy, $orderBy);

            if (!empty($search)) {
                $product->Where('name', 'LIKE', "%{$search}%");
            }
            if (!empty($productCategoryId)) {
                $product->where('product_category_id', $productCategoryId);
            }

            return ProductResponse::collection($product->paginate($limit))->response();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->sendError($th->getMessage(), 500);
        }
    }

    public function store (Request $request)
    {
        try {
            $input      = $request;
            $validator  = processRules($input, ProductRequest::getRules());
            if($validator->fails()) {
                return $this->sendError($validator->errors(), 400);
            }

            DB::beginTransaction();
            $user = Auth::user();
            $image = $request->file('image');
            $imageStore = $image->store('public/product/'.$user->email); // store to unique folder per user

            $product = Product::create([
                'product_category_id' => $input->product_category_id,
                'name' => $input->name,
                'price' => $input->price,
                'image' => $imageStore,
                'created_by' => $user->id,
            ]);
            DB::commit();
            return $this->sendResponse(new ProductResponse($this->findbyId($product->id)), 'Successed.', 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->sendError($th->getMessage(), 500);
        }
    }

    public function Update (Request $request, $id)
    {
        try {
            $input      = $request;
            $validator  = processRules($input, UpdateProductRequest::getRules());
            if($validator->fails()) {
                return $this->sendError($validator->errors(), 400);
            }

            $product = $this->findbyId($id);
            if (!$product) {
                return $this->sendError('Product is not found.', 404);
            }

            $user = Auth::user();
            if ($product->created_by != $user->id) {
                return $this->sendError('You can`t update other users` product.', 406);
            }

            DB::beginTransaction();
            $image = $request->file('image');
            if (!empty($image)) {
                Storage::delete($product->image); // delete old file
                $imageStore = $image->store('public/product/'.$user->email); // store to unique folder per user
                $product->image = $imageStore;
            }
            $product->product_category_id = $input->product_category_id;
            $product->name = $input->name;
            $product->price = $input->price;
            $product->save();
            DB::commit();

            $product = $this->findbyId($id);
            return $this->sendResponse(new ProductResponse($product), 'Successed.', 200);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), 500);
        }
    }


    public function destroy ($id)
    {
        try {
            DB::beginTransaction();
            $product = Product::find($id);
            if (!$product) {
                return $this->sendError('Product is not found.', 404);
            }
            $product->delete();
            Storage::delete($product->image);
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
            $product = $this->findbyId($id);
            return $this->sendResponse(new ProductResponse($product), 'Successed.', 200);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), 500);
        }
    }

    public function findbyId($id)
    {
        $product = Product::with('productCategory')->where('id', $id)->first();
        return $product;
    }
}
