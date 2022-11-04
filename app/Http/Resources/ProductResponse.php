<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($responsee)
    {
        $productCategory = $this->whenLoaded('productCategory');
        return [
            'id'     => $this->id,
            'product_category_id'     => $this->product_category_id,
            'product_category_name'     => $productCategory->name,
            'name'   => $this->name,
            'price'     => $this->price,
            'image'     => storageUrl($this->image),
            'created_at'  => date('Y-m-d H:i:s', strtotime($this->created_at)),
            'updated_at'  => date('Y-m-d H:i:s', strtotime($this->updated_at)),
        ];
    }
}
