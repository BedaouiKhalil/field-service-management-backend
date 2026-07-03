<?php

namespace App\Http\Controllers\Api;

use App\Constants\Permissions;
use App\Enums\TaskStatus;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\UpdateStatusRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{

    public function __construct(
        private TaskService $service
    ) {
        $this->middleware('permission:' . Permissions::VIEW_TASK)->only(['index', 'show']);
        $this->middleware('permission:' . Permissions::UPDATE_TASK_STATUS)->only(['updateStatus']);
    }


    public function index(Request $request)
    {
        $data = $this->service->list($request->all());

        return ApiResponse::paginated(collection: TaskResource::collection($data), message: 'Tasks list retrieved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return ApiResponse::success(message: 'task details retrieved successfully', data: new TaskResource($task));
    }

    public function updateStatus(UpdateStatusRequest $request, Task $task)
    {
        $this->authorize('updateStatus', $task);

        $validated = $request->validated();

        $updatedTask = $this->service->updateStatus($validated['status'], $task);

        return ApiResponse::success(
            message: 'Task status updated to ' . TaskStatus::from($request->status)->label(),
            data: new TaskResource($updatedTask)
        );
    }
}
