<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->paginate(10);

        return view('admin.admins.index', ['admins' => $admins]);
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(UserStoreRequest $request)
    {

        $data = $request->validated();

        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);


        $admin->assignRole('admin');

        return redirect()->route('admin.admins.edit', $admin->id)->with('success', 'User created successfully');
    }
    public function edit(User $admin)
    {
        return view('admin.admins.edit', ['admin' => $admin]);
    }

    public function update(AdminUpdateRequest $request, User $admin)
    {

        $admin->update($request->only('name', 'email', 'address', 'phone'));

        if ($request->change_password) {
            $admin->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.admins.show', $admin->id)->with('success', 'User updated successfully');
    }
    public function show(User $admin)
    {
        return view('admin.admins.show', ['admin' => $admin]);
    }

    public function destroy(User $admin)
    {
        // Delete related records in role_user, product_prices, and free_of_charges tables
        DB::table('role_user')->where('user_id', $admin->id)->delete();
        DB::table('product_prices')->where('user_id', $admin->id)->delete();
        DB::table('free_of_charges')->where('user_id', $admin->id)->delete();

        $admin->delete();

        return redirect()->route('admin.admins.index')->with('success', 'User deleted successfully');
    }
}
