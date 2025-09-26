@extends('layouts.auth.master')

@section('title', 'login')
@section('page-title', 'Sign In')
@section('page-subtitle', 'Access your personal account')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="m-sm-3">
                <form action="{{ route('login.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input class="form-control form-control-lg @error('email') is-invalid @enderror" type="email"
                            name="email" value="{{ old('email') }}" placeholder="Enter your email" />
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input class="form-control form-control-lg @error('password') is-invalid @enderror" type="password"
                            name="password" placeholder="Enter your password" />
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-grid gap-2 mt-3">
                        <button type="submit" class="btn btn-lg btn-primary">Sign in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
