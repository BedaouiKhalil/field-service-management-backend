@extends('layouts.admin.master')

@section('title', 'Users')
@section('page-title', 'Users')
@section('page-subtitle', 'List')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-header">
                    <div class="d-flex justify-content-start align-items-center">
                        <form action="{{ route('admin.users.index') }}" id="search-form" method="get">
                            <input type="text" class="form-control w-auto" name="keyword" value="{{ request('keyword') }}"
                                placeholder="Search...">
                        </form>
                        <div class="btn-group ms-1" role="group" aria-label="Basic example">
                            <button type="submit" class="btn btn-primary" form="search-form"><i
                                    data-feather="search"></i></button>
                            @can(\App\Constants\Permissions::MANAGE_USER)
                                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                    <i data-feather="plus"></i>
                                </a>
                            @endcan

                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-striped mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th style="min-width: 150px;">Full Name</th>
                                    <th>Active</th>
                                    <th>Email</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="text-muted">#{{ $user->id }}</td>

                                        <td class="fw-semibold">{{ $user->full_name }}</td>

                                        <td>
                                            @if ($user->is_active)
                                                <i data-feather="check" class="text-success" style="width:25px;height:25px;"></i>
                                            @else
                                                <i data-feather="x" class="text-danger" style="width:25px;height:25px;"></i>
                                            @endif
                                        </td>

                                        <td class="text-primary">{{ $user->email }}</td>

                                        <td>
                                            <button id="btnGroupDrop{{ $user->id }}" type="button"
                                                class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Action
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop{{ $user->id }}">
                                                @can(\App\Constants\Permissions::MANAGE_CUSTOMER)
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('admin.users.edit', $user->id) }}">Edit</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item text-danger btn-delete"
                                                            data-id="{{ $user->id }}">
                                                            Delete
                                                        </a>

                                                        <form id="delete-form-{{ $user->id }}"
                                                            action="{{ route('admin.users.destroy', $user->id) }}"
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
                        {{ $users->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
