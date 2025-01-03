<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Permissions', only: ['index']),
            new Middleware('permission:Edit Permissions', only: ['edit']),
            new Middleware('permission:Create Permissions', only: ['create']),
            new Middleware('permission:Delete Permissions', only: ['destroy']),
        ];
    }
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'desc')->paginate(10);
        return view('permissions.index', compact('permissions'));
    }
    public function create()
    {
        return view('permissions.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|unique:permissions,name'
            ]
        );
        Permission::create([
            'name' => $validated['name']
        ]);
        return to_route('permission.index')->with('success', 'Permission Created Successfully');
    }
    public function edit(int $id)
    {
        $permission = Permission::findOrfail($id);
        return view('permissions.edit', [
            'permission' => $permission
        ]);
    }
    public function update(int $id, Request $request){
        $permission = Permission::findOrfail($id);
        $validated = $request->validate(
            [
                'name' => 'required|unique:permissions,name,'.$id.',id'
            ]
        );
        $permission->name = $validated['name'];
        $permission->save();
        return to_route('permission.index')->with('success','Permission Update Successfully.');
    }
    public function destroy(Request $request){
        $id = $request->id;
        $permission = Permission::findOrfail($id);
        $permission->delete($id);
        return to_route('permission.index')->with('danger','Permission Deleted Successfully.');

    }
}
