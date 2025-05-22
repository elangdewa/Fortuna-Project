@extends('layouts.user')

@section('user-content')
    <div class="container">
        <h1>Pengaturan</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card mb-4">
            <div class="card-body">

                <h2 class="card-title" style="color: #080808;">Informasi Akun</h2>
                <div class="text-center mb-4">
                    @if($user->profile_photo)
                        <img src="{{ asset('storage/profile_photos/'.$user->profile_photo) }}"
                             class="rounded-circle" width="150" height="150" alt="Foto Profil">
                    @else
                        <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center"
                             style="width: 150px; height: 150px;">
                            <span class="text-white fs-1">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                    @endif
                </div>

             <form action="{{ route('user.setting.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT') <!-- Pastikan ini ada -->
    <div class="mb-3">
        <label for="profile_photo" class="form-label" style="color: #080808;">Foto Profil</label>
        <input type="file" class="form-control" id="profile_photo" name="profile_photo">
        @error('profile_photo')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label" style="color: #080808;">Nama</label>
                        <input type="text" class="form-control" id="name" name="name"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label" style="color: #080808;">Nomor Telepon</label>
                        <input type="tel" class="form-control" id="phone" name="phone"
                               value="{{ old('phone', $user->phone ?? '') }}" required>
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label" style="color: #080808;">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label" style="color: #080808;">Alamat</label>
                        <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $user->address ?? '') }}</textarea>
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="color: #080808;">Ganti Password</h2>

                {{-- Notifikasi password --}}
                @if (session('password_success'))
                    <div class="alert alert-success">{{ session('password_success') }}</div>
                @endif
                @if (session('password_error'))
                    <div class="alert alert-danger">{{ session('password_error') }}</div>
                @endif

                {{-- Form Ubah Password --}}
                <form action="{{ route('user.setting.password') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="current_password" class="form-label" style="color: #080808;">Password Terkini</label>
                        <input type="password" name="current_password" class="form-control" required>
                        @error('current_password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label" style="color: #080808;">Password Baru</label>
                        <input type="password" name="new_password" class="form-control" required>
                        @error('new_password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label" style="color: #080808;">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Ubah Password</button>
                </form>
                
            </div>
        </div>
    </div>

    <style>
    .container .card-body label,
    .container .card-body p,
    .container .card-body h2 {
        color: #080808 !important;
    }

    /* Menambahkan warna teks pada input */
    .container .card-body input,
    .container .card-body select,
    .container .card-body textarea {
        color: #080808 !important;
        background-color: white !important; /* Tambahkan ini */
    }

    /* Jika placeholder juga ingin diubah warnanya */
    .container .card-body input::placeholder,
    .container .card-body select::placeholder,
    .container .card-body textarea::placeholder {
        color: rgba(8, 8, 8, 0.7) !important;
    }

    /* Khusus untuk textarea alamat */
    #address {
        background-color: white !important;
    }
</style>

@endsection
