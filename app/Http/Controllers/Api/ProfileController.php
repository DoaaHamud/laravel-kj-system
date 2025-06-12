<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public function store(StoreProfileRequest $request)
    {
        try {
            $user_id = Auth::user()->id;
            $dataValidate = $request->validated();
            $dataValidate['user_id'] = $user_id;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filePath = 'images/profiles/';
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path($filePath), $fileName);
                $imagePath = $filePath . $fileName;
                $dataValidate['image'] = $imagePath;
            }
            $data = Profile::create($dataValidate);
            return response()->json(
                [
                    'status' => 'done',
                    'message' => 'create profile successfully',
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
        $profile = Auth::user()->profile;
        return response()->json(
            [
                'status' => 'success',
                'message' => 'get profile successfully',
                'data' => $profile
            ],
            200
        );
    }

    public function update(UpdateProfileRequest $request, $id)
    {
        $user_id = Auth::user()->id;
        $profile = Profile::findOrFail($id);
        if ($profile->user_id != $user_id) {
            return response()->json(['unauthorized']);
        }
        $data = $profile->update($request->validated());
        return response()->json(
            [
                'status' => 'success',
                'message' => 'update profile successfully',
                'data' => $data
            ],
            200
        );
    }

    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);
        $profile->delete();
        return response()->json(null, 204);
    }
}
