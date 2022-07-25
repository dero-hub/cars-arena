<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;


class Roles_controller extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function create(Request $request)
    {
        if($request->has('name')){
            $role = new Roles;
            $role->name = $request->name;
            $role->save();
            return response()->json(["success"=>"Role created","role" => $role], 201);
        } else {
            return response()->json(["error"=>"Input required!"], 400);
        }

    }

    public function findOne($id)
    {
        $role = Roles::find($id);

        if($role === null)
        {
            return response()->json(["error"=>"Role not found!"]);
        } else
        {
             return response()->json(["success", $role], 200);
        }
    }

    public function findAll()
    {
    $roles = Roles::all();
     return response()->json($roles, 200);
    }

    public function deleteOne($id)
    {
        $role = Roles::find($id);

        if($role === null)
        {
            return response()->json(["error"=>"Role not found!"], 200);
        } else
        {
           $role::destroy($id);
             return response()->json(["success" => "Role deleted successfully"], 200);
        }
    }

    public function deleteAll()
    {
        Roles::whereNotNull('id')->delete();
     return response()->json(["success" => "Roles deleted successfully"], 200);
    }
}
