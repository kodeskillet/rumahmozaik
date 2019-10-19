<?php

namespace App\Http\Controllers;

use App\Product;
use App\CatalogType;
use App\Laravue\JsonResponse;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;
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
        // $request->validate([
        //     'productName' => 'required',
        //     'catalogType' => 'required',
        //     'price' => 'required',
        //     // 'picture' => 'required|max:10240', //5MB
        // ]);

        $product = $request->isMethod('put') ? Product::findOrFail($request->id) : new Product;
        $product->productName = $request->productName;
        $product->catalogType = $request->catalogType;
        $product->picture = "http://i.pravatar.cc";
        $product->price = $request->price;

        if($product->save()){
            return response()->json([
                'message' => 'Insert Success'
            ]);
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
