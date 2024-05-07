<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\DriverUpdateRequest;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = User::whereHas('roles', function ($query) {
            $query->where('name', 'driver');
        })->paginate(10);

        return view('admin.drivers.index', ['drivers' => $drivers]);
    }

    public function create()
    {
        return view('admin.drivers.create');
    }

    public function store(UserStoreRequest $request)
    {

        $data = $request->validated();

        $driver = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);


        $driver->assignRole('driver');

        return redirect()->route('admin.drivers.edit', $driver->id)->with('success', 'User created successfully');
    }
    public function edit(User $driver)
    {
        return view('admin.drivers.edit', ['driver' => $driver]);
    }

    public function update(DriverUpdateRequest $request, User $driver)
    {

        $driver->update($request->only('name', 'email', 'address', 'phone'));

        if ($request->change_password) {
            $driver->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.drivers.show', $driver->id)->with('success', 'User updated successfully');
    }
    public function show(User $driver)
    {
        return view('admin.drivers.show', ['driver' => $driver]);
    }

    public function destroy(User $driver)
    {
        // Delete related records in role_user, product_prices, and free_of_charges tables
        DB::table('role_user')->where('user_id', $driver->id)->delete();
        DB::table('product_prices')->where('user_id', $driver->id)->delete();
        DB::table('free_of_charges')->where('user_id', $driver->id)->delete();

        $driver->delete();

        return redirect()->route('admin.drivers.index')->with('success', 'User deleted successfully');
    }
}
