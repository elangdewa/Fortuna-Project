@extends('layouts.app')

@section('content')

<link href="{{ asset('css/member.css') }}" rel="stylesheet">
@include('layouts.sidenavbar')

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Kelas Fitness</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addClassModal">
            Tambah Kelas Baru
        </button>

    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <!-- Table untuk menampilkan data kelas -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Kelas</th>
                            <th>Deskripsi</th>
                            <th>Kapasitas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($classes) && count($classes) > 0)
                            @foreach($classes as $class)
                                <tr>
                                    <td>{{ $class->id }}</td>
                                    <td>{{ $class->class_name }}</td>
                                    <td>{{ Str::limit($class->description, 50) }}</td>

                                    <td>{{ $class->capacity }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm edit-btn"
        data-id="{{ $class->id }}"
        data-class_name="{{ $class->class_name }}"
        data-description="{{ $class->description }}"
        data-capacity="{{ $class->capacity }}"
        data-bs-toggle="modal"
        data-bs-target="#editClassModal">
        Edit
    </button>

    <a href="{{ route('admin.fitness.schedules.index', $class->id) }}" class="btn btn-info btn-sm mt-1">
        Kelola Jadwal
    </a>

    <a href="{{ route('admin.fitness.members', $class->id) }}" class="btn btn-primary btn-sm mt-1">
        Lihat Member
    </a>

    <form action="{{ route('admin.fitness.destroy', $class->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm mt-1" onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">Hapus</button>
    </form>
</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data kelas fitness</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>



<!-- Modal Tambah Kelas -->
<div class="modal fade" id="addClassModal" tabindex="-1" aria-labelledby="addClassModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClassModalLabel">Tambah Kelas Fitness</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.fitness.store') }}" method="POST">

                    @csrf
                    <div class="mb-3">
                        <label for="class_name" class="form-label">Nama Kelas</label>
                        <input type="text" class="form-control" id="class_name" name="class_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="capacity" class="form-label">Kapasitas</label>
                        <input type="number" class="form-control" id="capacity" name="capacity" required>
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

<!-- Modal Edit Kelas -->
<div class="modal fade" id="editClassModal" tabindex="-1" aria-labelledby="editClassModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editClassModalLabel">Edit Kelas Fitness</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editClassForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_class_name" class="form-label">Nama Kelas</label>
                        <input type="text" class="form-control" id="edit_class_name" name="class_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit_capacity" class="form-label">Kapasitas</label>
                        <input type="number" class="form-control" id="edit_capacity" name="capacity" required>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Hanya jalankan jika ada tombol edit
        const editButtons = document.querySelectorAll('.edit-btn');

        if(editButtons.length > 0) {
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const className = this.getAttribute('data-class_name');
                    const description = this.getAttribute('data-description');

                    const capacity = this.getAttribute('data-capacity');

                    // Set nilai form
                    document.getElementById('edit_class_name').value = className;
                    document.getElementById('edit_description').value = description;

                    document.getElementById('edit_capacity').value = capacity;

                    // Set action form
                    const form = document.getElementById('editClassForm');
                    form.action = `/admin/fitness/update/${id}`;
                });
            });
        }
    });
</script>
@endpush
