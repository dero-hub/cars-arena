<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;




class Users_controller extends Controller
{

    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function userProfile() {
        return auth()->user();
    }
   
    public function update(Request $request)
    {
        $id = $this->userProfile()->id;
        $user = User::find($id);

        if($user === null)
        {
            return response()->json(["error" => "user not found"], 422);
        }
        if($request->has('name') || $request->has('phone') || $request->has('password'))
        {
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->password = $request->password;
            $user->save();

        }
        return $user;
    }

    public function deleteOne($id)
    {
        $user = User::find($id);

        if($user === null)
        {
            return response()->json(["error"=>"User not found!"], 200);
        } else
        {
           $user::destroy($id);
             return response()->json(["success" => "User deleted successfully"], 200);
        }
    }

    public function findAll()
    {
    $users = User::all();
     return response()->json($users, 200);
    }

    public function deleteAll()
    {
        User::whereNotNull('id')->delete();
     return response()->json(["success" => "Users deleted successfully"], 200);
    }
}
