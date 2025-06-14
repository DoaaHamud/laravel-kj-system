<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMealRequest;
use App\Http\Requests\UpdateMealRequest;
use App\Models\Child;
use App\Models\Meal;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MealController extends Controller
{
    public function store(StoreMealRequest $request)
    { 
      Gate::authorize('create' , Meal::class);
      $dataValidated = $request->validated();
      $meals = Meal::create($dataValidated);
      return response()->json($meals);
    }

    public function index()
    {  
        Gate::authorize('index' , Meal::class);
        $meals = Meal::all();
        return response()->json($meals);

    }

    public function getImagesForMeal($id)
    {
       $meals = Meal::findOrFail($id)->images;
       return response()->json($meals);

    }

    public function update(UpdateMealRequest $request ,$id)
    {   
        Gate::authorize('update' , Meal::class);
        $meals = Meal::findOrFail($id);
        $data = $meals->update($request->validated());
        return response()->json($data);
    }

    public function destroy($id)
    {   
        Gate::authorize('delete' , Meal::class);
        $meals = Meal::findOrFail($id);
        $meals->delete();
        return response()->json(null, 204);
    }

   
}
