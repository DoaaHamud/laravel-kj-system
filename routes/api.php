<?php

use App\Http\Controllers\Api\adminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChildController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\MealController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReportController;
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
        Route::post('assignMeal/{id}', 'assignMeal');
        Route::get('getChildMeals/{id}', 'getChildMeals');
    });

    Route::controller(ReportController::class)->group(function(){
        Route::post('store_report/{id}', 'store');
        Route::get('index_report/{id}', 'index');
        Route::put('update_report/{id}', 'update');
        Route::delete('delete_report/{id}', 'destroy');
    });

    Route::controller(MealController::class)->group(function(){
        Route::post('store_meal', 'store');
        Route::get('index_meal', 'index');
        Route::put('update_meal/{id}', 'update');
        Route::delete('delete_meal/{id}', 'destroy');
        Route::get('getImagesForMeal/{id}', 'getImagesForMeal');
        
    });

    Route::controller(ImageController::class)->group(function(){
        Route::post('uploadImage', 'uploadImage');
    });

    Route::controller(adminController::class)->group(function(){
       Route::post('assignExistingChildToTeacher', 'assignExistingChildToTeacher');
    });






});
