@extends('layouts.admin')

@section('admin-content')
    <link href="{{ asset('css/tableadmin.css') }}" rel="stylesheet">

    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card profile-header-card">
                    <div class="card-body text-white py-4">
                        <div class="d-flex align-items-center justify-content-center text-center">
                            <div>
                                <h2 class="mb-1 fw-bold">Profil Pengguna</h2>
                                <p class="mb-0 opacity-75">Kelola informasi akun Anda</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Profile Info Card -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header bg-white border-0 pb-0">
                        <div class="d-flex align-items-center">

                            <div>
                                <h5 class="card-title mb-1 fw-semibold">Informasi Profil</h5>
                                <small class="text-muted">Perbarui nama dan informasi dasar Anda</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        {{-- Notifikasi sukses untuk update nama --}}
                        @if (session('success'))
                            <div class="alert alert-success border-0 shadow-sm" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('admin.profile.update') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="fas fa-user me-2 text-primary"></i>Nama Pengguna
                                </label>
                                <input type="text"
                                    class="form-control form-control-lg border-0 shadow-sm @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $user->name) }}" required
                                    style="background-color: #f8f9fa;">

                                @error('name')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-envelope me-2 text-primary"></i>Email
                                </label>
                                <input type="email" class="form-control form-control-lg border-0 shadow-sm"
                                    value="{{ $user->email }}" readonly>
                                <small class="text-muted">Email tidak dapat diubah</small>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-warning btn-lg px-4 shadow-sm text-white"
                                    style="background-color: #da9100; border-color: #da9100;">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Form Ubah Password -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header bg-white border-0 pb-0">
                        <div class="d-flex align-items-center">

                            <div>
                                <h5 class="card-title mb-1 fw-semibold">Keamanan Akun</h5>
                                <small class="text-muted">Ubah password untuk keamanan yang lebih baik</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        {{-- Notifikasi sukses dan error untuk password --}}
                        @if (session('password_success'))
                            <div class="alert alert-success border-0 shadow-sm" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('password_success') }}
                                </div>
                            </div>
                        @endif

                        @if (session('password_error'))
                            <div class="alert alert-danger border-0 shadow-sm" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    {{ session('password_error') }}
                                </div>
                            </div>
                        @endif

                        {{-- Validasi error --}}
                        @if ($errors->has('current_password') || $errors->has('new_password'))
                            <div class="alert alert-danger border-0 shadow-sm" role="alert">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-exclamation-circle me-2 mt-1"></i>
                                    <div>
                                        <ul class="mb-0 ps-0" style="list-style: none;">
                                            @foreach ($errors->all() as $error)
                                                <li class="mb-1">• {{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('admin.profile.password') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="current_password" class="form-label fw-semibold">
                                    <i class="fas fa-key me-2 text-warning"></i>Password Saat Ini
                                </label>
                                <div class="input-group">
                                    <input type="password" name="current_password" id="current_password"
                                        class="form-control border-0 shadow-sm @error('current_password') is-invalid @enderror"
                                        required style="background-color: #f8f9fa;">
                                    <button class="btn btn-outline-secondary border-0" type="button"
                                        onclick="togglePassword('current_password')">
                                        <i class="bi bi-eye" id="current_password_icon"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="new_password" class="form-label fw-semibold">
                                    <i class="fas fa-lock me-2 text-warning"></i>Password Baru
                                </label>
                                <div class="input-group">
                                    <input type="password" name="new_password" id="new_password"
                                        class="form-control border-0 shadow-sm @error('new_password') is-invalid @enderror"
                                        required>
                                    <button class="btn btn-outline-secondary border-0" type="button"
                                        onclick="togglePassword('new_password')">
                                        <i class="bi bi-eye" id="new_password_icon"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Minimal 8 karakter</small>
                            </div>

                            <div class="mb-4">
                                <label for="new_password_confirmation" class="form-label fw-semibold">
                                    <i class="fas fa-check-double me-2 text-warning"></i>Konfirmasi Password Baru
                                </label>
                                <div class="input-group">
                                    <input type="password" name="new_password_confirmation"
                                        id="new_password_confirmation" class="form-control border-0 shadow-sm" required>
                                    <button class="btn btn-outline-secondary border-0" type="button"
                                        onclick="togglePassword('new_password_confirmation')">
                                        <i class="bi bi-eye" id="new_password_confirmation_icon"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-warning btn-lg px-4 shadow-sm text-white">
                                    <i class="fas fa-shield-alt me-2"></i>Ubah Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <script>
            function togglePassword(fieldId) {
                const passwordField = document.getElementById(fieldId);
                const icon = document.getElementById(fieldId + '_icon');

                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    passwordField.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            }

            // Auto hide alerts after 5 seconds
            document.addEventListener('DOMContentLoaded', function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    setTimeout(function() {
                        alert.style.transition = 'opacity 0.5s';
                        alert.style.opacity = '0';
                        setTimeout(function() {
                            alert.remove();
                        }, 500);
                    }, 5000);
                });
            });
        </script>

    @endsection
