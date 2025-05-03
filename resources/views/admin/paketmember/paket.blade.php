@extends('layouts.app')

@section('content')
<link href="{{ asset('css/member.css') }}" rel="stylesheet">
@include('layouts.sidenavbar')

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Paket Membership</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPaketModal">
            Tambah Paket Baru
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Table untuk menampilkan data paket -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Paket</th>
                            <th>Harga</th>
                            <th>Durasi (Bulan)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($membershipTypes as $type)
                            <tr>
                                <td>{{ $type->id }}</td>
                                <td>{{ $type->name }}</td>
                                <td>Rp {{ number_format($type->price) }}</td>
                                <td>{{ $type->duration_in_months }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-btn" 
                                        data-id="{{ $type->id }}"
                                        data-name="{{ $type->name }}"
                                        data-price="{{ $type->price }}"
                                        data-duration="{{ $type->duration_in_months }}"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editPaketModal">
                                        Edit
                                    </button>
                                   <!-- Corrected Delete Form -->
<form action="{{ route('admin.paketmember.destroy', $type->id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus paket ini?')">Hapus</button>
</form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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