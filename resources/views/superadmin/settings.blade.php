
@extends('layouts.superadmin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">System Settings</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('superadmin.settings.update') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Site Name</label>
                    <input type="text" class="form-control" name="site_name" value="{{ config('app.name') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Registration Enabled</label>
                    <select class="form-control" name="registration_enabled">
                        <option value="1">Enabled</option>
                        <option value="0">Disabled</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Maintenance Mode</label>
                    <select class="form-control" name="maintenance_mode">
                        <option value="0">Disabled</option>
                        <option value="1">Enabled</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
</div>
@endsection
