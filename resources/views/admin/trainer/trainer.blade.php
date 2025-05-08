@extends('layouts.app')
@section('content')
<link href="{{ asset('css/member.css') }}" rel="stylesheet">

@include('layouts.sidenavbar')

<div class="main-content" id="mainContent">
    <div class="container mt-5">
       

        <!-- Form Search -->
        <form action="{{ route('admin.trainers.index') }}" method="GET">
            <div class="input-group" style="max-width: 400px;">
                <input type="text" name="search" class="form-control" placeholder="Cari nama atau pengalaman..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </div>
        </form>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Daftar Trainers</h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTrainerModal">
                Tambah Trainer
            </button>
            <a href="{{ route('admin.trainer.orders') }}" class="btn btn-info">Lihat Pesanan Trainer</a>

        </div>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Table Trainers -->
        <div class="table-responsive">
            <table class="table table-bordered" style="background:white;">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Pengalaman</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trainers as $trainer)
                        <tr>
                            <td>{{ $trainer->name }}</td>
                            <td>{{ $trainer->experience }}</td>
                            <td>
                                <!-- Edit Button -->
                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editTrainerModal{{ $trainer->id }}">
                                    Edit
                                </button>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.trainers.destroy', $trainer->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit Trainer -->
                        <div class="modal fade" id="editTrainerModal{{ $trainer->id }}" tabindex="-1" aria-labelledby="editTrainerModalLabel{{ $trainer->id }}" aria-hidden="true">
                          <div class="modal-dialog">
                            <form action="{{ route('admin.trainers.update', $trainer->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="editTrainerModalLabel{{ $trainer->id }}">Edit Trainer</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                  <div class="mb-3">
                                    <label for="name{{ $trainer->id }}" class="form-label">Nama Trainer</label>
                                    <input type="text" class="form-control" id="name{{ $trainer->id }}" name="name" value="{{ $trainer->name }}" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="experience{{ $trainer->id }}" class="form-label">Pengalaman</label>
                                    <input type="text" class="form-control" id="experience{{ $trainer->id }}" name="experience" value="{{ $trainer->experience }}" required>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-success">Perbarui</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada trainer ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Add Trainer -->
<div class="modal fade" id="addTrainerModal" tabindex="-1" aria-labelledby="addTrainerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('admin.trainers.store') }}" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addTrainerModalLabel">Tambah Trainer Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="name" class="form-label">Nama</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
              <label for="experience" class="form-label">Pengalaman</label>
              <textarea class="form-control" id="experience" name="experience" rows="3" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </form>
    </div>
  </div>

@endsection
