<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\User;
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
        return view('admin.dashboard', compact('products', 'customers'));
    }
}
