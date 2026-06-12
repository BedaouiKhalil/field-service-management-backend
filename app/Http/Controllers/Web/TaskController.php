<?php

namespace App\Http\Controllers\Web;

use App\Constants\Permissions;
use App\Constants\Roles;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\AddRequest;
use App\Http\Requests\Task\EditRequest;
use App\Models\Customer;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function __construct(private TaskService $service)
    {
        $this->middleware('permission:' . Permissions::VIEW_TASK)->only(['index', 'show']);
        $this->middleware('permission:' . Permissions::MANAGE_TASK)->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = $this->service->list($request->all());

        return view('admin.tasks.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        $task->load([
            'customer',
            'technician',
        ]);

        return view('admin.tasks.show', compact('task'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()
            ->route('admin.tasks.index')
            ->with('success', 'Task created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('admin.tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditRequest $request, Task $task)
    {
        $this->service->update($request->validated(), $task);

        return redirect()
            ->route('admin.tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()
            ->back()
            ->with('success', 'Task deleted successfully.');
    }
}
