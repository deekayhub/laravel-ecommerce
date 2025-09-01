<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Product;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;
use App\Events\OrderCreated;

class OrderController extends Controller
{

     public function __construct()
    {
        $this->middleware('auth');
    }


    public function index($id)
    {
        $product = Product::findOrFail($id);
        return view('place-order', compact('product'));
    }

    public function myorders(){

        $orders = Orders::join('products', 'orders.product_id', '=', 'products.id')
                ->where('orders.user_id', Auth::id())
                ->select('orders.*', 'products.*')
                ->get();    
        return view('my-orders', compact('orders'));
    }

    public function placeOrder(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $validatedData = $request->validate([
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
        ]);


        // dd(Orders::latest());


        $order = new Orders();
        $order->product_id = $product->id;
        $order->user_id = Auth::id();
        $order->total_amount = $product->price;
        $order->phone = $validatedData['phone'];
        $order->shipping_address = $validatedData['address'];
        if ($order->save()) {
            event(new OrderCreated($order));
            return redirect()->route('home')->with('success', 'Order placed successfully!');
        }

        return redirect()->back()->with('error', 'Failed to place order.');
    }
}
