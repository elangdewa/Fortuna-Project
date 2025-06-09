@extends('layouts.admin')

@section('admin-content')
<link href="{{ asset('css/tableadmin.css') }}" rel="stylesheet">

<div class="main-content" id="mainContent">
    <div class="container-fluid p-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-3">Daftar Trainers</h2>
                <!-- Search Form -->
                <form action="{{ route('admin.trainers.index') }}" method="GET">
                    <div class="input-group" style="width: 300px;">
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Cari nama atau pengalaman..."
                               value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.trainers.index') }}"
                               class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
           <div>
    <button type="button"
            class="btn btn-custom-primary me-2"
            data-bs-toggle="modal"
            data-bs-target="#addTrainerModal">
        <i class="bi bi-plus-lg me-1"></i>Tambah Trainer
    </button>
    <a href="{{ route('admin.trainer.orders') }}"
       class="btn btn-custom-dark">
        <i class="bi bi-list-check me-1"></i>Lihat Pesanan
    </a>
</div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark-custom">
                    <tr>
                        <th style="width: 20%;">Nama</th>
                        <th style="width: 65%;">Pengalaman</th>
                        <th style="width: 15%; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trainers as $trainer)
                        <tr>
                            <td>{{ $trainer->name }}</td>
                            <td style="white-space: normal;">{{ $trainer->experience }}</td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <button type="button"
                                            class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editTrainerModal{{ $trainer->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('admin.trainers.destroy', $trainer->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal for each trainer -->
                        <div class="modal fade" id="editTrainerModal{{ $trainer->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="{{ route('admin.trainers.update', $trainer->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Trainer</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Trainer</label>
                                                <input type="text" class="form-control" name="name" value="{{ $trainer->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pengalaman</label>
                                                <textarea class="form-control" name="experience" rows="3" required>{{ $trainer->experience }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Perbarui</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4">
                                <div class="empty-state">
                                    <i class="bi bi-person-x text-muted mb-2"></i>
                                    <h5>Tidak ada trainer ditemukan</h5>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Trainer Modal -->
<div class="modal fade" id="addTrainerModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.trainers.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Trainer Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pengalaman</label>
                        <textarea class="form-control" name="experience" rows="3" required></textarea>
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
