<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OrderApiResource;
use App\Models\Order;
use App\Models\Grocery;
class OrderController extends Controller
{
    public function index(grocery $grocery)
    {
        return OrderApiResource::collection(Order::where('grocery_id', $grocery->id)
            ->with('products')
            ->orderBy('created_at', 'DESC')
            ->get());
    }

    public function show(Order $order)
    {
        return OrderApiResource::make($order->load('grocery', 'products'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $status = $request->current_status;
        $action = $request->action;

        // Check Reject 
        if (!$action && $status == 'pending') {
            $order->status = 'rejected';
            $order->save();
            return 'Order Rejected!';
        }

        // If positive action
        if ($action) {
            switch ($status) {
                case 'pending':
                    $order->status = 'accepted';
                    $order->save();
                    break;
                case 'accepted':
                    $order->status = 'prepared';
                    $order->save();
                    break;
                case 'prepared':
                    $order->status = 'delivered';
                    $order->save();
                    break;
                case 'delivered':
                    $order->status = 'closed';
                    $order->save();
                    break;
            }

            return 'Order status updated!';
        }
    }
}
