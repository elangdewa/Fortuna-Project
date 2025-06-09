<link rel="stylesheet" href="{{ asset('css/alluser.css') }}">
@extends('layouts.user')

@section('user-content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-gear-fill text-white fs-5"></i>
                    </div>
                </div>
                <div>
                    <h1 class="mb-0 fw-bold text-dark">Pengaturan Akun</h1>
                    <p class="text-muted mb-0">Kelola informasi profil dan keamanan akun Anda</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('password_success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-shield-check me-2"></i>
            {{ session('password_success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('password_error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('password_error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-person-fill text-primary fs-5"></i>
                        </div>
                        <div>
                            <h4 class="mb-0 fw-bold text-dark">Informasi Profil</h4>
                            <p class="text-muted mb-0 small">Update foto profil dan informasi personal Anda</p>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Profile Photo Section -->
                    <div class="text-center mb-4 pb-4 border-bottom">
                        <div class="position-relative d-inline-block">
                            @if($user->profile_photo)
                                <img src="{{ asset('storage/profile_photos/'.$user->profile_photo) }}"
                                     class="rounded-circle shadow" width="120" height="120" alt="Foto Profil"
                                     style="object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center shadow"
                                     style="width: 120px; height: 120px;">
                                    <span class="text-white" style="font-size: 2.5rem; font-weight: 600;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                            <div class="position-absolute bottom-0 end-0 bg-white rounded-circle p-2 shadow-sm border">
                                <i class="bi bi-camera text-primary"></i>
                            </div>
                        </div>
                        <h5 class="mt-3 mb-1 fw-bold text-dark">{{ $user->name }}</h5>
                        <p class="text-muted small mb-0">{{ $user->email }}</p>
                    </div>

                    <!-- Profile Form -->
                    <form action="{{ route('user.setting.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="profile_photo" class="form-label fw-semibold text-dark">
                                    <i class="bi bi-image me-2"></i>Foto Profil
                                </label>
                                <input type="file" class="form-control form-control-lg border-2"
                                       id="profile_photo" name="profile_photo" accept="image/*">
                                @error('profile_photo')
                                    <div class="text-danger small mt-1">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label fw-semibold text-dark">
                                    <i class="bi bi-person me-2"></i>Nama Lengkap
                                </label>
                                <input type="text" class="form-control form-control-lg border-2"
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="text-danger small mt-1">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label fw-semibold text-dark">
                                    <i class="bi bi-telephone me-2"></i>Nomor Telepon
                                </label>
                                <input type="tel" class="form-control form-control-lg border-2"
                                       id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}" required>
                                @error('phone')
                                    <div class="text-danger small mt-1">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="email" class="form-label fw-semibold text-dark">
                                    <i class="bi bi-envelope me-2"></i>Email Address
                                </label>
                                <input type="email" class="form-control form-control-lg border-2"
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="text-danger small mt-1">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-12 mb-4">
                                <label for="address" class="form-label fw-semibold text-dark">
                                    <i class="bi bi-geo-alt me-2"></i>Alamat Lengkap
                                </label>
                                <textarea class="form-control form-control-lg border-2"
                                          id="address" name="address" rows="3"
                                          placeholder="Masukkan alamat lengkap Anda">{{ old('address', $user->address ?? '') }}</textarea>
                                @error('address')
                                    <div class="text-danger small mt-1">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg fw-semibold">
                                <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Change Password Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-shield-lock text-warning fs-5"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Keamanan</h5>
                            <p class="text-muted mb-0 small">Ubah password akun</p>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('user.setting.password') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="current_password" class="form-label text-dark fw-semibold small">
                                Password Saat Ini
                            </label>
                            <input type="password" name="current_password"
                                   class="form-control border-2" required
                                   placeholder="Masukkan password saat ini">
                            @error('current_password')
                                <div class="text-danger small mt-1">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label text-dark fw-semibold small">
                                Password Baru
                            </label>
                            <input type="password" name="new_password"
                                   class="form-control border-2" required
                                   placeholder="Masukkan password baru">
                            @error('new_password')
                                <div class="text-danger small mt-1">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="new_password_confirmation" class="form-label text-dark fw-semibold small">
                                Konfirmasi Password
                            </label>
                            <input type="password" name="new_password_confirmation"
                                   class="form-control border-2" required
                                   placeholder="Ulangi password baru">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning fw-semibold">
                                <i class="bi bi-shield-check me-2"></i>Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Account Actions Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-4">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="bi bi-box-arrow-right text-danger fs-5"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Aksi Akun</h5>
                            <p class="text-muted mb-0 small">Kelola sesi akun Anda</p>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="bg-light rounded-3 p-3 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-info-circle text-muted me-2"></i>
                            <small class="text-muted">
                                Anda akan keluar dari semua perangkat yang terhubung
                            </small>
                        </div>
                    </div>

                   <form id="logout-form" action="{{ route('logout') }}" method="POST">
    @csrf
    <div class="d-grid">
        <button type="button" class="btn btn-outline-danger fw-semibold" onclick="confirmLogout()">
            <i class="bi bi-box-arrow-right me-2"></i>Keluar dari Akun
        </button>
    </div>
</form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmLogout() {
    Swal.fire({
        title: 'Keluar dari akun?',
        text: "Anda akan keluar dari sesi login.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Logout',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
        }
    });
}
</script>
