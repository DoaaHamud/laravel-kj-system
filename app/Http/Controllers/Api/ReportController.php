<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\Child;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Exception;

class ReportController extends Controller
{
    public function store(StoreReportRequest $request, $id)
    {   
        try{ 
        Gate::authorize('create' , Report::class);
        $child_id = Child::findOrFail($id);
        $dataValidate = $request->validated();
        $dataValidate['child_id'] = $child_id->id;
        
        $report = Report::create($dataValidate);
        return response()->json($report);
        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function index($id)
    {   
        Gate::authorize('index' , Report::class);
        $report = Child::findOrFail($id)->reports;
        return response()->json($report);
    }

    public function update(UpdateReportRequest $request, $id)
    {  
        Gate::authorize('update' , Report::class);
       $report = Report::findOrFail($id);
       $data = $report->update($request->validated());
       return response()->json(['status' => 'success', 'message' => 'update report successfully', 'data' => $report], 201);
    }

     public function destroy($id)
    {   
        Gate::authorize('delete' , Report::class);
        $report = Report::findOrFail($id);
        $report->delete();
        return response()->json(null, 204);
    }
}
