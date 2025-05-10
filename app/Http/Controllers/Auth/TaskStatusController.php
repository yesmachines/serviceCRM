<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TaskStatusController extends Controller
{
    
     public function index(Request $request){


     return view('auth.task_statuses.index');
   }

   

     public function getData(Request $request)
    {
        $query = TaskStatus::select('id', 'status', 'priority', 'active');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('priority', function ($row) {
                return $row->priority ?: '-';
            })
            ->editColumn('active', function ($row) {
                return $row->active ? 'Yes' : 'No';
            })
            ->addColumn('actions', function ($row) {
                return view('auth.task_statuses.actions', ['status' => $row])->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function create(){

        return view('auth.task_statuses.create');
    }

       public function store(Request $request)
        {
            $request->validate([
                'status' => 'required|string|max:255',
                'priority' => 'required|string|max:255',
                'active' => 'nullable|boolean',
            ]);

            TaskStatus::create([
                'status' => $request->input('status'),
                'priority' => $request->input('priority'),
                'active' => $request->has('active'),
            ]);

            return redirect()->route('task-statuses.index')->with('success', 'Task status created successfully.');
    }

    public function edit(TaskStatus $taskStatus)
    {
        return view('auth.task_statuses.edit', compact('taskStatus'));
    }

     public function update(Request $request, TaskStatus $taskStatus)
    {
        $request->validate([
            'status' => 'required|string|max:255',
            'priority' => 'required|string|max:255',
            'active' => 'nullable|boolean',
        ]);

        $taskStatus->update([
            'status' => $request->input('status'),
            'priority' => $request->input('priority'),
            'active' => $request->has('active'),
        ]);

        return redirect()->route('task-statuses.index')->with('success', 'Task status updated successfully.');
    }

    /**
     * Remove the specified job status from storage.
     */
    public function destroy(TaskStatus $taskStatus)
    {
        $taskStatus->delete();

        return response()->json(['status' => true, 'message' => 'Task status deleted successfully.']);
    }


}
