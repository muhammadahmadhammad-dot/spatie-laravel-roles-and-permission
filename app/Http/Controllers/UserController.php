<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Users', only: ['index']),
            new Middleware('permission:Edit Users', only: ['edit']),
            new Middleware('permission:Create Users', only: ['create']),
            new Middleware('permission:Delete Users', only: ['destroy']),
        ];
    }
    public function index()
    {
        $users = User::latest()->get();
        return view('users.index', compact('users'));
    }
    public function create()
    {
        $roles = Role::orderBy('name', 'ASC')->get();
        return view('users.create', compact('roles'));
    }
    public function store(Request $request)
    {
        $validated  = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::create(
            [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]
        );

        if(!empty($request->roles)){
            $user->assignRole($request->roles);
        }

        return to_route('user.index')->with('success','User Created Successfully');
    }
    public function edit(User $user) {
        $roles = Role::orderBy('create_at','DESC')->get();

        $hasRoles = $user->roles->pluck('id');
        return view('users.edit' , compact('user','roles','hasRoles')); 
    }
    public function update(Request $request, User $user) {
        $validated  = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$user->id.',id',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        

        $user->syncRoles($request->roles);
     

        return to_route('user.index')->with('success','User Updated Successfully');
    
    }
    public function destroy(User $user) {
        $user->delete();
        return to_route('user.index')->with('danger','User Deleted Successfully');

    }
}
