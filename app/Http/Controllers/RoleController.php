<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:View Roles', only: ['index']),
            new Middleware('permission:Edit Roles', only: ['edit']),
            new Middleware('permission:Create Roles', only: ['create']),
            new Middleware('permission:Delete Roles', only: ['destroy']),
        ];
    }
    
    public function index(){
        $roles = Role::latest()->paginate(4);
        return view('roles.index',compact('roles'));
    }
    public function create(){
        $permissions =Permission::orderBy('name','asc')->get();
        return view('roles.create',compact('permissions'));
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required|unique:roles,name'
        ]);
        if($validator->passes()){

            $role = Role::create(['name'=>$request->name]);
            if(!empty($request->permission)){
                foreach($request->permission as $permission){
                    $role->givePermissionTo($permission);
                }
            }
            
            return to_route('role.index')->with('success','Role Created Successfully');
        }else{
            return to_route('role.create')->withInput()->withErrors($validator);

        }

    }
    public function edit(int $id){
        $role = Role::findOrfail($id);
        $permissions = Permission::orderBy('name','asc')->get();
        $hasPermissions = $role->permissions->pluck('name');
        return view('roles.edit',compact('role','permissions','hasPermissions'));
    }
    public function update(Request $request,int $id){
        $validator = Validator::make($request->all(),[
            'name'=>'required|unique:roles,name,'.$id.',id'
        ]);
        if($validator->passes()){

            $role = Role::findOrfail($id);
            $role->name = $request->name;
            $role->save();

            if(!empty($request->permission)){
                    $role->syncPermissions($request->permission);
            }else{
                $role->syncPermissions([]);

            }
            
            return to_route('role.index')->with('success','Role Updated Successfully');
        }else{
            return to_route('role.create')->withInput()->withErrors($validator);

        }
    }
    public function destroy(int $id){
        $role = Role::findOrfail($id);
        $role->delete();
        return to_route('role.index')->with('danger','Role delete Successfully');

    } 

}
