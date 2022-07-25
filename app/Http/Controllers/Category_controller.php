<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;


class Category_controller extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function create(Request $request)
    {
        if($request->has('name')){
            $category = new Category;
            $category->name = $request->name;
            $category->save();
            return response()->json(["success"=>"Category created","role" => $category], 201);
        } else {
            return response()->json(["error"=>"Input required!"], 400);
        }

    }

    public function findOne($id)
    {
        $category = Category::find($id);

        if($category === null)
        {
            return response()->json(["error"=>"Category not found!"]);
        } else
        {
             return response()->json(["success", $category], 200);
        }
    }

    public function findAll()
    {
    $categories = Category::all();
     return response()->json($categories, 200);
    }

    public function deleteOne($id)
    {
        $category = Category::find($id);

        if($category === null)
        {
            return response()->json(["error"=>"Category not found!"], 200);
        } else
        {
           $category::destroy($id);
             return response()->json(["success" => "Category deleted successfully"], 200);
        }
    }

    public function deleteAll()
    {
        Category::whereNotNull('id')->delete();
     return response()->json(["success" => "Categories deleted successfully"], 200);
    }
}
