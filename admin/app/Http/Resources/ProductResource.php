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
            'catalogName'=>$this->catalogName,
            'catalogType'=>CatalogTypeResource::collection($this->catalogType),
            'picture'=>$this->picture,
            'harga'=>$this->harga,
        ];
    }
}
