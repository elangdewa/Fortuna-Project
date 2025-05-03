@extends('layouts.admin')

@section('admin-content')

<div class="container mt-5">
    <h3 class="text-success fw-bold">Informasi Admin</h3>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Profil Info -->
    <div class="card p-3 mt-3 shadow-sm">
        <h1>Welcome, {{ auth()->user()->name }}</h1>
    </div>

    <!-- Ganti Username -->
    <div class="card p-3 mt-3 shadow-sm">
        <h5>Ganti Nama Pengguna</h5>
        <form action="{{ route('admin.update.username') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="newUsername" class="form-label">Nama Pengguna Baru</label>
                <input type="text" class="form-control" id="newUsername" name="name" 
                       value="{{ auth()->user()->name }}" required>
                    
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
        </form>
    </div>

    <!-- Ganti Password -->
    <div class="card p-3 mt-3 shadow-sm">
        <h5>Ganti Password</h5>
        <form action="{{ route('admin.update.password') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="currentPassword" class="form-label">Password Saat Ini</label>
                <input type="password" class="form-control" id="currentPassword" name="current_password" required>
            </div>
            <div class="mb-3">
                <label for="newPassword" class="form-label">Password Baru</label>
                <input type="password" class="form-control" id="newPassword" name="new_password" required>
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Ulangi Password Baru</label>
                <input type="password" class="form-control" id="confirmPassword" name="new_password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-success">Ganti Password</button>
        </form>
    </div>
</div>

@endsection
