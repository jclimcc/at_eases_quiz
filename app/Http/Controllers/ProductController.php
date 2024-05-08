<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        //list out all product
        $products = Product::paginate(10);
        return view('admin.products.index', ['products' => $products]);
    }
    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $product = Product::create([
            'name' => $request->name,
        ]);


        return redirect()->route('admin.products.edit', $product->id)->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', ['product' => $product]);
    }

    public function update(Request $request, Product $product)
    {

        $product->update($request->only('name'));


        return redirect()->route('admin.products.show', $product->id)->with('success', 'Product updated successfully');
    }
    public function show(Product $product)
    {
        return view('admin.products.show', ['product' => $product]);
    }

    public function destroy(Product $product)
    {
        // Delete related records in role_user, product_prices, and free_of_charges tables
        // DB::table('role_user')->where('user_id', $user->id)->delete();
        // DB::table('product_prices')->where('user_id', $user->id)->delete();
        // DB::table('free_of_charges')->where('user_id', $user->id)->delete();

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }

    public function productDetailsShow(Product $product)
    {



        $productPrices = DB::table('products')
            ->join('product_prices', 'products.id', '=', 'product_prices.product_id')
            ->join('free_of_charges', 'products.id', '=', 'free_of_charges.product_id')
            ->join('users', 'users.id', '=', 'product_prices.user_id')
            ->select('products.id', 'products.name as product_name', 'product_prices.price', 'users.id as user_id', 'users.name as user_name', 'product_prices.unit', 'free_of_charges.type', 'free_of_charges.threshold', 'free_of_charges.free_amount')
            ->where('products.id', $product->id)
            ->whereRaw('free_of_charges.user_id = product_prices.user_id')
            ->paginate(10);

        // dd($productPrices);
        return view('admin.products.details.show', ['productPrices' => $productPrices, 'product_name' => $product->name, 'product_id' => $product->id]);
    }
    public function productDetailsStore(Request $request, Product $product)
    {

        $product = Product::find($request->product_id);
        $request->validate([
            'price' => 'required|numeric',
            'unit' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
            'threshold' => 'required|numeric',
            'free_amount' =>  ['numeric', Rule::requiredIf($request->type === 'order_units')],
            'type' => 'required|string|in:quantity,order_units',
        ]);

        $product->productPrices()->create([
            'price' => $request->price,
            'unit' => $request->unit,
            'user_id' => $request->user_id,
        ]);

        $product->freeOfCharges()->create([
            'type' => $request->type,
            'threshold' => $request->threshold,
            'free_amount' => $request->free_amount,
            'user_id' => $request->user_id,
        ]);
        //capture the insert query

        return redirect()->route('admin.products.details.show', $product->id)->with('success', 'Product price created successfully');
    }
    public function productDetailsEdit(Request $request, Product $product)
    {

        $product = Product::find($request->product_id);
        $request->validate([
            'mprice' => 'required|numeric',
            'munit' => 'required|numeric',
            'muser_id' => 'required|exists:users,id',
            'mthreshold' => 'required|numeric',
            'mfree_amount' =>  ['numeric', Rule::requiredIf($request->type === 'order_units')],
            'mtype' => 'required|string|in:quantity,order_units',
        ]);

        $product->productPrices()->where('user_id', $request->muser_id)->update([
            'price' => $request->mprice,
            'unit' => $request->munit,
        ]);

        $product->freeOfCharges()->where('user_id', $request->muser_id)->update([
            'type' => $request->mtype,
            'threshold' => $request->mthreshold,
            'free_amount' => $request->mfree_amount,
        ]);
        //capture the insert query

        return redirect()->route('admin.products.details.show', $product->id)->with('success', 'Product price created successfully');
    }
}
