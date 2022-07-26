<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cars;
use Cloudinary\Api\Upload\UploadApi;


class Cars_controller extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function create(Request $request)
    {

        $uploadedFileUrl = (new UploadApi())->upload($request->file('image')->getRealPath());

        if($request->has('model') 
        && $request->has('name') 
        && $request->has('cc') 
        && $request->has('year')
        && $request->has('price')){

            $car = new Cars;

            $car->model = $request->model;
            $car->name = $request->name;
            $car->cc = $request->cc;
            $car->year = $request->year;
            $car->price = $request->price;
            $car->image = $uploadedFileUrl['secure_url'];


            $car->save();
            return response()->json(["success"=>"Car created","Car" => $car], 201);
        } else {
            return response()->json(["error"=>"All input fields are required!"], 400);
        }

    }

    public function update(Request $request, $id)
    {
        $uploadedFileUrl = (new UploadApi())->upload($request->file('image')->getRealPath());

        if($request->has('model') 
        || $request->has('name') 
        || $request->has('cc') 
        || $request->has('year')
        || $request->has('price')){

            $car = Cars::find($id);

            $car->model = $request->model;
            $car->name = $request->name;
            $car->cc = $request->cc;
            $car->year = $request->year;
            $car->price = $request->price;
            $car->image = $uploadedFileUrl['secure_url'];


            $car->save();
            return response()->json(["success"=>"Car Updated","Car" => $car], 201);
        } else {
            return response()->json(["error"=>"At least one input field is required!"], 400);
        }

    }


    public function findOne($id)
    {
        $car = Cars::find($id);

        if($car === null)
        {
            return response()->json(["error"=>"Car not found!"]);
        } else
        {
             return response()->json(["success", $car], 200);
        }
    }

    public function findAll()
    {
    $cars = Cars::all();
     return response()->json($cars, 200);
    }

    public function deleteOne($id)
    {
        $car = Cars::find($id);

        if($car === null)
        {
            return response()->json(["error"=>"Car not found!"], 200);
        } else
        {
           $car::destroy($id);
             return response()->json(["success" => "Car deleted successfully"], 200);
        }
    }

    public function deleteAll()
    {
        Cars::whereNotNull('id')->delete();
     return response()->json(["success" => "All cars deleted successfully"], 200);
    }
}
