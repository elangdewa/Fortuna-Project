{{-- resources/views/admin/profile.blade.php --}}
@extends('layouts.admin')

@section('admin-content')
    <div class="container">
        <h1>Profil Pengguna</h1>

        {{-- Notifikasi sukses untuk update nama --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Form Ubah Nama --}}
        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Pengguna</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>

                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <p><strong>Email:</strong> {{ $user->email }}</p>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>

        <hr>

        <h2>Ubah Password</h2>

        {{-- Notifikasi sukses dan error untuk password --}}
        @if (session('password_success'))
            <div class="alert alert-success">{{ session('password_success') }}</div>
        @endif

        @if (session('password_error'))
            <div class="alert alert-danger">{{ session('password_error') }}</div>
        @endif

        {{-- Validasi error --}}
        @if ($errors->has('current_password') || $errors->has('new_password'))
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Ubah Password --}}
        <form action="{{ route('admin.profile.password') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="current_password" class="form-label">Password Saat Ini</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Password Baru</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-warning">Ubah Password</button>
        </form>
    </div>
@endsection
