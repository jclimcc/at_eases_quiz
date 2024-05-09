<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Middleware\User;
use App\Models\ProductPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //show user productPrice 
        $user = Auth::user();
        // $products = $user->products->productPrices;
        // //get the productPrices 
        // $products->load('productPrices');
        // dd($products);
        $products = ProductPrice::where('product_prices.user_id', $user->id)
            ->join('products', 'product_prices.product_id', '=', 'products.id')
            ->join('free_of_charges as foc', function ($join) {
                $join->on('foc.product_id', '=', 'products.id')
                    ->on('foc.user_id', '=', 'product_prices.user_id');
            })
            ->select('product_prices.*', 'products.name as product_name', 'foc.type as foc_type', 'foc.threshold as foc_threshold', 'foc.free_amount as foc_free_amount')
            ->get();

        // dd($products);

        return view('front.user.products', compact('products'));
    }
    public function carts()
    {
        $products = session('products', []);

        return view('front.user.carts', compact('products'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
