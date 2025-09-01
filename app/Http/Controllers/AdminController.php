<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\User;
use App\Models\Orders;
use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $products = Product::latest()->limit(5)->get();
        $customers = User::latest()->limit(5)->get();
        $orders = Orders::join('products', 'orders.product_id', '=', 'products.id')
                ->select('orders.*', 'products.*')
                ->limit(10)
                ->get();
                // dd($orders->toArray());
        return view('admin.dashboard', compact('products', 'customers', 'orders'));
    }
}
