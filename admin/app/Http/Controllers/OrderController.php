<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\CatalogType;
use App\OrderItem;
use App\Laravue\JsonResponse;
use App\Http\Resources\OrderResource;
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
                                    'product.productName',
                                    'product.price',
                                    'product.picture',
                                    'order_item.amount'
                                )
                                ->where('order_id', $order->id)
                                ->get();
        }
        $json = json_encode(OrderResource::collection($orders));
        return $json;
    }

    public function show(Request $request)
    {
        $order = Order::findOrFail($request->id);
        $order->orderItem = DB::table('order_item')
        ->join('product', 'order_item.product_id', '=', 'product.id')
        ->select(
            'order_item.product_id',
            'order_item.order_id',
            'product.productName',
            'product.price',
            'product.picture',
            'order_item.amount'
        )
        ->where('order_id', $order->id)
        ->get();
        $json = json_encode(new OrderResource($order));
        return $json;
    }

    public function store(Request $request)
    {
        $order = new Order;
        $order->name = $request->name;
        $order->email = $request->email;
        $order->whatsapp = $request->whatsapp;
        $order->status = "PROSES";
        $order->save();

        $orderId = $order->id;
        $cart = $request->cart;
        if(is_array($cart)){
            foreach($cart as $item){
                $order_item = new OrderItem;
                $order_item->order_id = $orderId;
                $order_item->product_id = $item->productId;
                $order_item->amount = $item->amount;
                $order_item->save();
            }
            return response()->json([
                'message' => 'Success'
            ]);
        }
        $order_item = new OrderItem;
        $order_item->order_id = $orderId;
        $order_item->product_id = $cart->productId;
        $order_item->amount = $cart->amount;
        $order_item->save();

        return response()->json([
            'message' => 'Success'
        ]);
    }

    public function statechange(Request $request)
    {
        $order = Order::findOrFail($request->id);
        $order->status = "SELESAI";
        $order->save();
        return response()->json([
            'message' => 'Success'
        ]);
    }
}
