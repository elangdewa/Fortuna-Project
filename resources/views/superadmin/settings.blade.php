@extends('layouts.superadmin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Account Settings</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Update Email -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('superadmin.settings.update') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="email">
                <div class="mb-3">
                    <label class="form-label">New Email</label>
                    <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Email</button>
            </form>
        </div>
    </div>

    <!-- Update Password -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('superadmin.settings.update') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="password">
                <div class="mb-3">
                    <label class="form-label">Current Password</label>
                    <input type="password" class="form-control" name="current_password" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" name="password_confirmation" required>
                </div>
                <button type="submit" class="btn btn-warning">Update Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
