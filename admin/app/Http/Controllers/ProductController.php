<?php

namespace App\Http\Controllers;

use App\Product;
use App\Laravue\JsonResponse;
use App\Resources\ProductResource;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $Product = Product::all();
        return ProductResource::Collection($Product);
    }

    public function store(Request $request)
    {

    }

    public function show ($id)
    {

    }

    public function destroy($id)
    {

    }
}
