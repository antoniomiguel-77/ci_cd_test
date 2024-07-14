<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user/token', function (Request $request) {
    dd($request->user()->createText());
})->middleware('auth:sanctum');


Route::resource("users",UserController::class)->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function(){
    Route::post("/user/login","login");
    Route::get("/user/logout","logout")->middleware("auth");
});
