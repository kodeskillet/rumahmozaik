<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CatalogType;
use App\Http\Resources\CatalogTypeResource;

class CatalogTypeController extends Controller
{
    public function index()
    {
        $type = CatalogType::all();
        return CatalogTypeResource::Collection($type);
    }

    public function store(Request $request)
    {
        $type = $request->isMethod('put') ? CatalogType::findOrFail($request->id) : new CatalogType;
        $type->name = $request->input('name');

        if($type->save()){
            return response()->json([
                'message' => 'Insert Success'
            ]);
        }
    }

    public function show ($id)
    {
        $type = CatalogType::findOrFail($id);
        return new CatalogTypeResource($type);
    }

    public function destroy($id)
    {
        $type = CatalogTypeResource::findOrFail($id);

        //  Delete the post, return as confirmation
        if ($type->delete()) {
            return new CatalogTypeResource($post);
        }
    }
}
