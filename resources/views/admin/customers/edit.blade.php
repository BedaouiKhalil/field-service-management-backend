@extends('layouts.admin.master')

@section('title', 'Customers')
@section('page-title', 'Edit Customer')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="card-body">

                    <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST" class="row g-3">
                        @csrf
                        @method('PUT')

                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $customer->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="contact_name" class="form-label">Contact Name</label>
                            <input type="text" class="form-control @error('contact_name') is-invalid @enderror"
                                id="contact_name" name="contact_name"
                                value="{{ old('contact_name', $customer->contact_name) }}">
                            @error('contact_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                name="phone" value="{{ old('phone', $customer->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email', $customer->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="nif" class="form-label">NIF</label>
                            <input type="text" class="form-control @error('nif') is-invalid @enderror" id="nif"
                                name="nif" value="{{ old('nif', $customer->nif) }}">
                            @error('nif')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <x-form.location-selector :wilayas="$wilayas" :selectedWilaya="old('wilaya_id', $customer->wilaya_id)" :selectedCommune="old('commune_id', $customer->commune_id)" />

                        <div class="col-md-12">
                            <label for="address" class="form-label">Address</label>
                            <textarea rows="3" class="form-control @error('address') is-invalid @enderror" id="address" name="address">{{ old('address', $customer->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Edit Customer</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
