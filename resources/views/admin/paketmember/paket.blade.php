@extends('layouts.admin')

@section('admin-content')
<link href="{{ asset('css/tableadmin.css') }}" rel="stylesheet">

<div class="main-content" id="mainContent">
    <div class="container-fluid px-0">

        <div class="page-header mb-3 ps-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="page-title mb-0">
                    <i class="fas fa-ticket-alt me-2"></i>
                    Paket Membership
                </h2>
                <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addPaketModal">
                    <i class="fas fa-plus me-1"></i>Tambah Paket
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Table Card -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 60px">ID</th>
                                <th style="width: 200px">Nama Paket</th>
                                <th style="width: 150px">Harga</th>
                                <th style="width: 120px">Durasi</th>
                                <th style="width: 120px" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($membershipTypes as $type)
                                <tr>
                                    <td class="text-center">{{ $type->id }}</td>
                                    <td>{{ $type->name }}</td>
                                    <td>Rp {{ number_format($type->price, 0, ',', '.') }}</td>
                                    <td>{{ $type->duration_in_months }} Bulan</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm edit-btn"
                                            data-id="{{ $type->id }}"
                                            data-name="{{ $type->name }}"
                                            data-price="{{ $type->price }}"
                                            data-duration="{{ $type->duration_in_months }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editPaketModal">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('admin.paketmember.destroy', $type->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus paket ini?')">
                                                            <i class="bi bi-trash-fill"></i>

                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="empty-state">
                                            <i class="fas fa-ticket-alt text-muted mb-2"></i>
                                            <h5 class="text-muted">Belum ada paket membership</h5>
                                            <p class="text-muted mb-0">Silakan tambah paket baru</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Paket -->
<div class="modal fade" id="addPaketModal" tabindex="-1" aria-labelledby="addPaketModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPaketModalLabel">Tambah Paket Membership</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.paketmember.store') }}" method="POST" id="addPaketForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Paket</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga (Rp)</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="duration_in_months" class="form-label">Durasi (Bulan)</label>
                        <input type="number" class="form-control" id="duration_in_months" name="duration_in_months" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Paket -->
<div class="modal fade" id="editPaketModal" tabindex="-1" aria-labelledby="editPaketModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPaketModalLabel">Edit Paket Membership</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPaketForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nama Paket</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_price" class="form-label">Harga (Rp)</label>
                        <input type="number" class="form-control" id="edit_price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_duration_in_months" class="form-label">Durasi (Bulan)</label>
                        <input type="number" class="form-control" id="edit_duration_in_months" name="duration_in_months" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Script untuk mengisi data pada modal edit
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-btn');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const price = this.getAttribute('data-price');
                const duration = this.getAttribute('data-duration');

                document.getElementById('edit_name').value = name;
                document.getElementById('edit_price').value = price;
                document.getElementById('edit_duration_in_months').value = duration;

                // Update form action URL
                document.getElementById('editPaketForm').action = `/admin/paketmember/${id}`;
            });
        });
    });
</script>
@endpush
