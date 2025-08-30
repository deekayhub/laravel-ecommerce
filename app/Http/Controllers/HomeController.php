<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Product;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        $search = $request->input('search');
        $products = Product::latest()
            ->when($search, fn($query) =>
                $query->where('name', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%")
            )
            ->paginate(20);
        return view('home', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('view-product', compact('product'));
    }
}
