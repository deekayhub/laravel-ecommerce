<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Events\OrderStatusUpdated;  

class OrderController extends Controller
{
    public function index()
    {
        $allOrders = Orders::join('products', 'orders.product_id', '=', 'products.id')
                            ->join('users', 'orders.user_id', '=', 'users.id')
                    ->select('orders.*', 'orders.id as order_id', 'products.*', 'users.name as user_name')
                    ->paginate(10);
                    // dd($allOrders->toArray());

        return view('admin.orders', compact('allOrders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Orders::findOrFail($id);
        
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,shipped,delivered'
        ]);

        $order->status = $validated['status'];
        $order->save();
        if($order->save()) {
            broadcast(new OrderStatusUpdated($order))->toOthers();

            return redirect()->route('admin.orders')
                ->with('success', 'Order status updated successfully.');
        }else{
            return redirect()->back()->with('error', 'Failed to update order status.');
        }

    }
}
