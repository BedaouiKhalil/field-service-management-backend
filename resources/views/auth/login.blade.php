@extends('layouts.auth.master')

@section('title', 'login')
@section('page-title', 'Sign In')
@section('page-subtitle', 'Access your personal account')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="m-sm-3">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input class="form-control form-control-lg" type="email" name="email"
                            placeholder="Enter your email" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input class="form-control form-control-lg" type="password" name="password"
                            placeholder="Enter your password" />
                    </div>
                    <div>
                        <div class="form-check align-items-center">
                            <input id="customControlInline" type="checkbox" class="form-check-input" value="remember-me"
                                name="remember-me" checked>
                            <label class="form-check-label text-small" for="customControlInline">Remember me</label>
                        </div>
                    </div>
                    <div class="d-grid gap-2 mt-3">
                        <a href="index.html" class="btn btn-lg btn-primary">Sign in</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
