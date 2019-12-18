<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\CatalogType;
use App\Laravue\JsonResponse;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CatalogTypeResource;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        foreach($orders as $order){
            $order->orderItem = DB::table('order_item')
                                ->join('product', 'order_item.product_id', '=', 'product.id')
                                ->select(
                                    'order_item.product_id',
                                    'order_item.order_id',
                                    'order_item.amount',
                                    'product.productName',
                                    'product.price'
                                )
                                ->where('order_id', $order->id)
                                ->get();
        }
        $json = json_encode(OrderResource::collection($orders));
        return $json;
    }
}
