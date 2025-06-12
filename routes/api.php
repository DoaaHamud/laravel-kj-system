<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChildController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function(){

    Route::controller(ProfileController::class)->group(function(){
        Route::post('store_Profile','store');
        Route::get('index_Profile','index');
        Route::put('update_Profile/{id}','update');
        Route::delete('delete_Profile/{id}','destroy');
    });

    Route::controller(ChildController::class)->group(function(){
        Route::post('store_child', 'store');
        Route::get('index_child', 'index');
        Route::put('update_child/{id}', 'update');
        Route::delete('delete_child/{id}', 'destroy');
    });






});
