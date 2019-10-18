<?php

namespace App\Http\Controllers;

use App\Product;
use App\CatalogType;
use App\Laravue\JsonResponse;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CatalogTypeResource;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::all();
        return ProductResource::Collection($product);
    }

    public function store(Request $request)
    {
        $product = $request->isMethod('put') ? Product::findOrFail($request->id) : new Product;
        $product->catalogName = $request->input('catalogName');
        $product->catalogType = $request->input('catalogType');
        $product->picture = "http://i.pravatar.cc";
        $product->harga = $request->input('harga');

        if($product->save()){
            return new ProductResource($product);
        }
    }

    public function show ($id)
    {
        $product = Product::findOrFail($id);
        return new ProductResource($product);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        //  Delete the post, return as confirmation
        if ($product->delete()) {
            return new ProductResource($product);
        }
    }

}
