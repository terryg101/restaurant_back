<?php

namespace App\Http\Controllers;

use illuminate\Http\Request;
use App\Models\Role;


    class RoleController extends Controller

{
    public function index(){
        try{

        $roles=Role::all();

        if($roles->count()>0){
            return response()->json([$roles], 200);
        }
        else{
            return "No Role was found!";
        }
        } catch(\Exception $e){
            return "Error fetching Roles";
        }
    }

    public function createRole(Request $request){
        $validated = $request -> validate([
            "name" => "required|string|max:255|unique:roles",
            "slug" => "required|string|max:255|unique:roles",
            "description" => "nullable|string|max:1000",
        ]);

        try{
            $role = Role::create($validated);

            if($role){
                return response()->json(["Created Role", $role], 200);
            }
            else{
                return "No Role was found";
            }
        }
        catch(\Exception $e){
            return "Error Creating Role";
        }
    }

    public function getRole($id){
        try{
            $role = Role::findOrfai($id);
            if($role->count()>0){
                return response()->json([$role],200);
            }
            else{
                return "Role Was Not Found for ID: '$id'";
            }
        }
        catch(\Exception $e){
            return "";
        }
    }

    public function updateRole(Request $request, $id){
    $validated = $request -> validate([
        "name" => "required|string|max:255|unique:roles",
        "slug" => "required|string|max:255|unique:roles",
        "description" => "nullable|string|max:1000",
    ]);
    $role = Role::findOrfai($id);

    try{


        $role = Role::put($validated);
        if($role){
            return response()->json([$role], 200);
        }
        else{
            return "Role Was Not Found for ID: $id";
        }

    }
    catch(\Exception $e){
        return response()->json([
            "Error"=>"Error Updating Role '$e'"
        ], 401);

    }
}
    public function deleteRole($id){
        $role= Role::findOrfail($id);

        try{
            if($role){
                Role::destroy($id);
                return "Role has been deleted";
            }
            else{
                return "Role was not deleted";
            }
        }
        catch(\Exception $e){
            return "Error deleting the record";
        }
    }

}

