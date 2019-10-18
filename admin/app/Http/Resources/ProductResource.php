<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'productName'=>$this->productName,
            'catalogType'=>$this->catalogType,
            'picture'=>$this->picture,
            'price'=>$this->price,
        ];
    }
}
