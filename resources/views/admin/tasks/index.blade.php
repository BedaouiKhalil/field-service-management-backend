@extends('layouts.admin.master')

@section('title', 'Tasks')
@section('page-title', 'Tasks')
@section('page-subtitle', 'List')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-header">
                    <form action="{{ route('admin.tasks.index') }}" id="search-form" method="get"
                        class="row g-2 align-items-center">

                        <div class="col-md-3">
                            <input type="text" class="form-control" name="title" value="{{ request('title') }}"
                                placeholder="Search ...">
                        </div>

                        <div class="col-md-3">
                            <select class="form-select" name="status">
                                <option value="">All statuses</option>

                                @foreach (\App\Enums\TaskStatus::options() as $value => $label)
                                    <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <x-customer-select :show-label="false" :selected="request('customer_id')"/>

                        <x-user-select :role-name="\App\Constants\Roles::TECHNICIAN"  :label="false" name="technician_id" :selected="request('technician_id')" />


                        <div class="col-md-5 d-flex justify-content-start">
                            <button type="submit" class="btn btn-primary">
                                <i data-feather="search"></i>
                            </button>

                            @can(\App\Constants\Permissions::MANAGE_TASK)
                                <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">
                                    <i data-feather="plus"></i>
                                </a>
                            @endcan
                        </div>

                    </form>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-striped mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th style="min-width: 150px;">title</th>
                                    <th>status</th>
                                    <th>Customer</th>
                                    <th>Technician</th>
                                    <th style="min-width: 150px;">Started at</th>
                                    <th style="min-width: 150px;">Completed at</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr>
                                        <td class="text-muted">#{{ $task->id }}</td>

                                        <td class="fw-semibold">{{ $task->title }}</td>

                                        <td>
                                            <span class="badge bg-{{ $task->status->color() }}">
                                                {{ $task->status->label() }}
                                            </span>
                                        </td>

                                        <td>{{ $task->customer?->name }}</td>

                                        <td>{{ $task->technician?->full_name }}</td>

                                        <td>{{ $task->started_at }}</td>

                                        <td>{{ $task->completed_at }}</td>


                                        <td><button id="btnGroupDrop{{ $task->id }}" type="button"
                                                class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Action
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop{{ $task->id }}">
                                                @can(\App\Constants\Permissions::MANAGE_TASK)
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('admin.tasks.edit', $task->id) }}">Edit</a>
                                                    </li>
                                                @endcan
                                                <li><a class="dropdown-item"
                                                        href="{{ route('admin.tasks.show', $task->id) }}">Show</a>
                                                </li>
                                                @can(\App\Constants\Permissions::MANAGE_TASK)
                                                    <li>
                                                        <a href="#" class="dropdown-item text-danger btn-delete"
                                                            data-id="{{ $task->id }}">
                                                            Delete
                                                        </a>

                                                        <form id="delete-form-{{ $task->id }}"
                                                            action="{{ route('admin.tasks.destroy', $task->id) }}"
                                                            method="POST" style="display:none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-white border-top d-flex justify-content-end align-items-center">
                    <nav aria-label="Page navigation">
                        {{ $tasks->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
