<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChildRequest;
use App\Http\Requests\UpdateChildRequest;
use App\Models\Child;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChildController extends Controller
{
    public function store(StoreChildRequest $request)
    {

        try {
            $user_id = Auth::user()->id;
            $dataValidate = $request->validated();
            $dataValidate['user_id'] = $user_id;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filePath = 'images/children/';
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path($filePath), $fileName);
                $imagePath = $filePath . $fileName;
                $dataValidate['image'] = $imagePath;
            }
            $data = Child::create($dataValidate);
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'created child successfully',
                    'data' => $data
                ],
                200
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $e->getMessage()
                ],
                400
            );
        }
    }

    public function index()
    {
        $children = Auth::user()->children;
        return response()->json(
            [
                'status' => 'success',
                'message' => 'get children successfully',
                'data' => $children
            ],
            200
        );
    }

    public function update(UpdateChildRequest $request, $id)
    {
        try {
            $user_id = Auth::user()->id;
            $children = Child::findOrFail($id);

            if ($children->user_id != $user_id) {
                return response()->json(['unauthorized']);
            }
            $data = $children->update($request->validated());
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'updated child successfully',
                    'data' => $children
                ],
                201
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $e->getMessage()
                ],
                400
            );
        }
    }

    public function destroy($id)
{
    $user_id = Auth::user()->id; 
    $child = Child::findOrFail($id);


    if ($child->user_id != $user_id) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $child->delete();

    return response()->json(null, 204);
}
}
