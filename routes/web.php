<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\Front\UserController as FrontUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'user'])->name('dashboard');

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
});
Route::prefix('front')->middleware(['auth', 'user'])->group(function () {
    Route::get('/user/dashboard', [FrontUserController::class, 'index'])->name('front.user.dashboard');
    Route::get('/user/products', [FrontUserController::class, 'index'])->name('front.user.products');
    Route::get('/user/carts', [FrontUserController::class, 'carts'])->name('front.user.carts');
});
Route::prefix('driver')->middleware(['auth', 'driver'])->group(function () {
    Route::get('/dashboard', function () {
        return view('driver.dashboard');
    })->name('front.driver.dashboard');

    Route::get('/customerlist', [DriverController::class, 'customerList'])->name('front.driver.customerList');
});

Route::prefix('data')->group(function () {
    Route::get('/order', function () {

        //insert a dummy order
        $order = new \App\Models\Order();
        $order->user_id = 1;
        $order->order_id = 'ORD-0001';
        $order->address = '123, Main Street, New York';
        $order->remarks = 'Please deliver before 5 PM';
        $order->is_paid = false;
        $order->user_id = 1;
        $order->driver_assigned = null;
        $order->assigned_by = null;
        $order->save();

        //attach products to the order
        $orderItem = new \App\Models\OrderItem();
        $orderItem->order_id = $order->id;
        $orderItem->product_id = 1;
        $orderItem->product_name = 'Product 1';
        $orderItem->quantity = 2;
        $orderItem->price = 100;
        $orderItem->total = 200;
        $orderItem->foc_type = 'quantity';
        $orderItem->foc_threshold = 10;
        $orderItem->foc_free_amount = 1;
        $orderItem->save();

        $orderItem = new \App\Models\OrderItem();
        $orderItem->order_id = $order->id;
        $orderItem->product_id = 2;
        $orderItem->product_name = 'Product 2';
        $orderItem->quantity = 3;
        $orderItem->price = 100;
        $orderItem->total = 300;
        $orderItem->foc_type = 'quantity';
        $orderItem->foc_threshold = 10;
        $orderItem->foc_free_amount = 1;
        $orderItem->save();
    })->name('data.order');
});


Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    //create resource route for users
    Route::resource('users', UserController::class)->names([
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'index' => 'admin.users.index',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
        'show' => 'admin.users.show',
    ]);
    Route::resource('drivers', DriverController::class)->names([
        'create' => 'admin.drivers.create',
        'store' => 'admin.drivers.store',
        'index' => 'admin.drivers.index',
        'edit' => 'admin.drivers.edit',
        'update' => 'admin.drivers.update',
        'destroy' => 'admin.drivers.destroy',
        'show' => 'admin.drivers.show',
    ]);
    Route::resource('admins', AdminController::class)->names([
        'create' => 'admin.admins.create',
        'store' => 'admin.admins.store',
        'index' => 'admin.admins.index',
        'edit' => 'admin.admins.edit',
        'update' => 'admin.admins.update',
        'destroy' => 'admin.admins.destroy',
        'show' => 'admin.admins.show',
    ]);
    Route::resource('products', ProductController::class)->names([
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'index' => 'admin.products.index',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
        'show' => 'admin.products.show',
    ]);

    Route::get('products/{product}/details', [ProductController::class, 'productDetailsShow'])->name('admin.products.details.show');
    Route::put('products/{product}/details/store', [ProductController::class, 'productDetailsStore'])->name('admin.products.details.store');
    Route::put('products/{product}/details/update', [ProductController::class, 'productDetailsEdit'])->name('admin.products.details.edit');


    Route::get('/customers/search', function (Request $request) {
        $term = $request->get('term');
        $product_id = $request->get('product_id');

        //search on productPrices get all the product_id  get the

        return  User::where('name', 'like', '%' . $term . '%')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'user');
            })
            ->whereDoesntHave('products', function ($query) use ($product_id) {
                $query->where('product_id', $product_id);
            })
            ->get(['id', 'name'])
            ->map(function ($user) {
                return ['id' => $user->id, 'label' => $user->name];
            });
    })->name('admin.customers.search');
});

require __DIR__ . '/auth.php';
