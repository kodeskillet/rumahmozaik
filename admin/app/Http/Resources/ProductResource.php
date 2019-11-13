<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CatalogTypeResource;

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
            'catalogName'=>$this->catalogName,
            'picture'=>$this->picture,
            'price'=>$this->price,
        ];
    }
}
