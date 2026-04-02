@extends('layouts.admin.master')

@section('title', 'Customers')
@section('page-title', 'Customers')
@section('page-subtitle', 'List')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-header">
                    <div class="d-flex justify-content-start align-items-center">
                        <form action="{{ route('admin.customers.index') }}" id="search-form" method="get">
                            <input type="text" class="form-control w-auto" name="name" value="{{ request('name') }}"
                                placeholder="Search...">
                        </form>
                        <div class="btn-group ms-1" role="group" aria-label="Basic example">
                            <button type="submit" class="btn btn-primary" form="search-form"><i
                                    data-feather="search"></i></button>
                            @can(\App\Constants\Permissions::MANAGE_CUSTOMER)
                                <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">
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
                                    <th style="min-width: 150px;">Name</th>
                                    <th>Contact</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Nif</th>
                                    <th style="min-width: 150px;">Location</th>
                                    <th style="min-width: 200px;">Address</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($customers as $customer)
                                    <tr>
                                        <td class="text-muted">#{{ $customer->id }}</td>

                                        <td class="fw-semibold">{{ $customer->name }}</td>

                                        <td>{{ $customer->contact_name }}</td>

                                        <td>{{ $customer->phone }}</td>

                                        <td class="text-primary">{{ $customer->email }}</td>

                                        <td>
                                            <span class="badge bg-light text-dark">
                                                {{ $customer->nif }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="small text-muted">
                                                {{ $customer->wilaya?->name }} <br>
                                                <strong>{{ $customer->commune?->name }}</strong>
                                            </div>
                                        </td>

                                        <td class="text-muted">{{ $customer->address }}</td>
                                        <td><button id="btnGroupDrop{{ $customer->id }}" type="button"
                                                class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                Action
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop{{ $customer->id }}">
                                                @can(\App\Constants\Permissions::MANAGE_CUSTOMER)
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('admin.customers.edit', $customer->id) }}">Edit</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item text-danger btn-delete"
                                                            data-id="{{ $customer->id }}">
                                                            Delete
                                                        </a>

                                                        <form id="delete-form-{{ $customer->id }}"
                                                            action="{{ route('admin.customers.destroy', $customer->id) }}"
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
                        {{ $customers->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
