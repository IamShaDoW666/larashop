<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        return
        $orders = OrderResource::collection(Order::where('restorant_id', 1)
            ->with('products')
            ->orderBy('created_at', 'DESC')
            ->get());
    }
}
