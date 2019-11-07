<?php

namespace App\Http\Controllers;

use App\Product;
use App\CatalogType;
use App\Laravue\JsonResponse;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CatalogTypeResource;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::all()->sortBy('catalogName');
        foreach($product as $aproduct){
            $aproduct->catalogName = DB::table('catalog_type')
                ->select('name')
                ->where('id',$aproduct->catalogType)
                ->first();
        }
        $json = json_encode(ProductResource::collection($product));
        return $json;


        // $json = json_encode($product);
        // return $json;
        // $json = json_decode($json);
        // foreach($json as $data){
        //     var_dump($data->productName);
        // }
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:52,428', //50MB
        // ]);

        $filenameWithExt = $request->file('picture')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('picture')->getClientOriginalExtension();
        $fileNameToStore = time().'_'.$filename.'.'.$extension;
        $path = $request->file('picture')->storeAs('public/products', $fileNameToStore);

        $product = $request->isMethod('put') ? Product::findOrFail($request->id) : new Product;
        $product->productName = $request->productName;
        $product->catalogType = $request->catalogType;
        $product->picture = $fileNameToStore;
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
        return json_encode($product);
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        //  Delete the post, return as confirmation
        if ($product->delete()) {
            return response()->json([
                'message' => 'Delete Success'
            ]);
        }
    }

}
