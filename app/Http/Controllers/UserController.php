<?php

namespace App\Http\Controllers;

use App\Models\User;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->paginate(10);

        return view('admin.users.index', ['users' => $users]);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(UserStoreRequest $request)
    {

        $data = $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);


        $user->assignRole('user');

        return redirect()->route('admin.users.edit', $user->id)->with('success', 'User created successfully');
    }
    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    public function update(UserUpdateRequest $request, User $user)
    {

        $user->update($request->only('name', 'email', 'address', 'phone'));

        if ($request->change_password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.show', $user->id)->with('success', 'User updated successfully');
    }
    public function show(User $user)
    {
        return view('admin.users.show', ['user' => $user]);
    }

    public function destroy(User $user)
    {
        // Delete related records in role_user, product_prices, and free_of_charges tables
        DB::table('role_user')->where('user_id', $user->id)->delete();
        DB::table('product_prices')->where('user_id', $user->id)->delete();
        DB::table('free_of_charges')->where('user_id', $user->id)->delete();

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
