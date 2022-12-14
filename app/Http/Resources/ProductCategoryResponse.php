<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($responsee)
    {
        return [
            'id'     => $this->id,
            'name'   => $this->name,
            'created_at'  => date('Y-m-d H:i:s', strtotime($this->created_at)),
            'updated_at'  => date('Y-m-d H:i:s', strtotime($this->updated_at)),
        ];
    }
}
