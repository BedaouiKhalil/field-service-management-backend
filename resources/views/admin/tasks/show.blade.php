@extends('layouts.admin.master')

@section('title', 'Task Details')
@section('page-title', 'Task Details')

@section('content')

<div class="row">

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">{{ $task->title }}</h3>
            </div>

            <div class="card-body">

                <div class="mb-4">
                    <h6 class="text-muted">Description</h6>
                    <p class="mb-0">
                        {{ $task->description ?: 'No description available.' }}
                    </p>
                </div>

                <hr>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Customer</small>
                        <strong>{{ $task->customer?->name ?? '-' }}</strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Technician</small>
                        <strong>{{ $task->technician?->full_name ?? '-' }}</strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Started At</small>
                        <strong>{{ $task->started_at ?? '-' }}</strong>
                    </div>

                    <div class="col-md-6 mb-3">
                        <small class="text-muted d-block">Completed At</small>
                        <strong>{{ $task->completed_at ?? '-' }}</strong>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="col-md-4">

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Task Information</h5>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <small class="text-muted d-block">ID</small>
                    <strong>#{{ $task->id }}</strong>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">Status</small>

                    <span class="badge bg-{{ $task->status->color() }}">
                        {{ $task->status->label() }}
                    </span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">Created At</small>
                    <strong>{{ $task->created_at }}</strong>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">Updated At</small>
                    <strong>{{ $task->updated_at }}</strong>
                </div>

                <hr>

                <div class="d-grid gap-2">

                    @can(\App\Constants\Permissions::MANAGE_TASK)
                        <a href="{{ route('admin.tasks.edit', $task) }}"
                            class="btn btn-primary">
                            Edit Task
                        </a>
                    @endcan

                    <a href="{{ route('admin.tasks.index') }}"
                        class="btn btn-outline-secondary">
                        Back to List
                    </a>

                </div>

            </div>
        </div>

    </div>

</div>

@endsection
