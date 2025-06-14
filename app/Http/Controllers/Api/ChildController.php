<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChildRequest;
use App\Http\Requests\UpdateChildRequest;
use App\Models\Child;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ChildController extends Controller
{
    public function store(StoreChildRequest $request)
    {

        try {
            Gate::authorize('create', Child::class);
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
        Gate::authorize('index', Child::class);
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
            Gate::authorize('update', Child::class);
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
        Gate::authorize('delete', Child::class);
        $user_id = Auth::user()->id;
        $child = Child::findOrFail($id);


        if ($child->user_id != $user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $child->delete();

        return response()->json(null, 204);
    }

    public function assignMeal(Request $request, $child_Id)
    {
        Gate::authorize('update', Child::class);

        $child = Child::findOrFail($child_Id);

        // تحقق من أن الطفل يخص المستخدم الحالي
        if ($child->user_id != Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'meal_id' => 'required|exists:meals,id',
        ]);

        // إرفاق الوجبة بالطفل
        $child->meals()->attach($validated['meal_id']);

        return response()->json([
            'status' => 'success',
            'message' => 'Meal assigned to child successfully'
        ]);
    }

    public function getChildMeals($childId)
{
    Gate::authorize('view', Child::class); // أو الصلاحية المناسبة عندك

    $child = Child::findOrFail($childId);

    // تأكدي أن الطفل يخص المستخدم
    if ($child->user_id != Auth::id()) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    // تحميل الوجبات المرتبطة
    $child->load('meals');

    return response()->json([
        'status' => 'success',
        'message' => 'Child meals retrieved successfully',
        'data' => $child->meals
    ]);
}

}
