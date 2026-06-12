@extends('layouts.admin.master')

@section('title', 'New Tasks')
@section('page-title', 'New Task')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-body">

                    <form action="{{ route('admin.tasks.store') }}" method="POST" class="row g-3">
                        @csrf

                        <div class="col-12">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <x-customer-select :selected="old('customer_id')" />

                        <x-user-select :role-name="\App\Constants\Roles::TECHNICIAN" :label="'Technician'" name="technician_id" :selected="old('technician_id')" />

                        <div class="col-md-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea rows="3" class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Create Task</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
