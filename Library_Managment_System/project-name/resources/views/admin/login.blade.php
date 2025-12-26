@extends('admin.layouts.app')

@section('content')
    <h1>Admin Login</h1>
    <form method="post" action="{{ route('admin.login.post') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input name="username" class="form-control" value="{{ old('username') }}">
            @error('username') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input name="password" type="password" class="form-control">
            @error('password') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <button class="btn btn-primary">Login</button>
    </form>
@endsection