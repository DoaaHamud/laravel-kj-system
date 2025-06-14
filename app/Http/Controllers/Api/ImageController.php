<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ImageController extends Controller
{
     public function uploadImage(Request $request ,$id)
    {   
        Gate::authorize('upload' , Image::class);
        $request->validate([
            'image'=>'required|array',
            'image.*'=>'required|image|mimes:jpeg,png,jpg.svg,gif'
        ]);
        $imageUrls=[];
        $menu=Meal::findOrFail($id);
        if(!$menu){
            return response()->json([
                'status'=>'error',
                'message'=>'menu not found'
            ],404);
        }
        $filePath='images/meals';
        foreach($request->file('image') as $file){
            $fileName=time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path($filePath), $fileName);
            $imagePath=$filePath.$fileName;
            $imageUrls[]=[
                'menu_id'=>$menu->id,
                'image'=>url($imagePath)
            ];
        }
        Image::insert($imageUrls);
        return response()->json([
            'status'=>'success',
            'message'=>'upload successfully',
            'data'=>$imageUrls
        ],200);

    }
}
