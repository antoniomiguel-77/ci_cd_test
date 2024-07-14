<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $search = Request("search");

        try {
            $users = [];
            if (!is_null($search)) {
                $users = UserResource::collection(
                    User::where("name","like","%".$search."%")
                    ->orWhere("email",$search)
                    ->get()
                );

            }else{
                $users = UserResource::collection(User::get());
            }


            return response()->json([
                "data"=>$users
            ],200);
          

        } catch (\Throwable $th) {

            return response()->json(["error"=>"Bad Request"],400);

        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {

        try {
            $users = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->email),
            ]);

            return response()->json([
                "data"=>$users,
                "message"=>"User Created Successfuly"
            ],201);

        } catch (\Throwable $th) {

            return response()->json(["error"=>"Bad Request"],400);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        try {
          

            $user = UserResource::collection(
                User::where("id",$id)->get()
            );
        
            
            return response()->json([
                "data"=>$user,
            ],201);

        } catch (\Throwable $th) {

            return response()->json(["error"=>$th->getMessage()],400);

        }
    }

   

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request,String $id)
    {
        
        try {
          User::find($id)->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->email),
            ]);

            

            return response()->json([
                "message"=>"User Updated Successfuly"
            ],201);

        } catch (\Throwable $th) {

            return response()->json(["error"=>$th->getMessage()],400);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        try {
            User::destroy($id);

            return response()->json([
                "message"=>"User Deleted Successfuly"
            ],201);

        } catch (\Throwable $th) {

            return response()->json(["error"=>"Bad Request"],400);

        }
    }
}
