@extends('layouts.admin')

@section('admin-content')
<link href="{{ asset('css/tableadmin.css') }}" rel="stylesheet">

<div class="container mt-5 px-0">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center px-3">
            <h2 class="page-title">Kelas Fitness</h2>
            <button type="button" class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#addClassModal">
                <i class="fas fa-plus me-1"></i> Tambah Kelas Baru
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-3 mx-3 animate__animated animate__fadeIn">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mb-3 mx-3 animate__animated animate__fadeIn">{{ session('error') }}</div>
    @endif

      <a href="{{ route('admin.export.fitness.all') }}" class="btn btn-primary">
        <i class="bi bi-file-earmark-excel"></i> Export Semua Jadwal & Member
    </a>

    <form action="{{ route('admin.export.fitness.single') }}" method="GET">
    <div class="mb-3">
        <label for="class_id" class="form-label">Pilih Kelas</label>
        <select name="class_id" id="class_id" class="form-select" required>
            @foreach ($allClasses as $schedule)
                <option value="{{ $schedule->id }}">
                    {{ $schedule->fitnessClass->class_name }} - {{ \Carbon\Carbon::parse($schedule->date)->format('d M Y') }}
                </option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-warning">
        <i class="bi bi-download me-1"></i> Export Kelas Terpilih
    </button>
</form>
</div>

    <!-- Table Card -->
    <div class="card mx-0">
        <div class="card-header bg-dark-custom">
            <h5 class="mb-0 text-white" style="font-size: 1rem;">
                <i class="fas fa-table me-2"></i>Data Kelas
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-dark-custom">
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th style="width: 150px;">Nama Kelas</th>
                            <th>Deskripsi</th>
                            <th style="width: 100px;">Kapasitas</th>
                            <th class="col-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($classes) && count($classes) > 0)
                            @foreach($classes as $class)
                                <tr>
                                    <td>{{ $class->id }}</td>
                                    <td>
                                        <span class="text-truncate-custom" title="{{ $class->class_name }}">
                                            {{ $class->class_name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-truncate-custom" title="{{ $class->description }}">
                                            {{ Str::limit($class->description, 50) }}
                                        </span>
                                    </td>
                                    <td>{{ $class->capacity }}</td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-warning btn-sm edit-btn"
                                                data-id="{{ $class->id }}"
                                                data-class_name="{{ $class->class_name }}"
                                                data-description="{{ $class->description }}"
                                                data-capacity="{{ $class->capacity }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editClassModal">
                                               <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <a href="{{ route('admin.fitness.schedules.index', $class->id) }}"
                                               class="btn btn-info btn-sm">
                                                <i class="bi bi-calendar"></i>
                                            </a>
                                            {{-- <a href="{{ route('admin.fitness.members', $class->id) }}"
                                               class="btn btn-primary-custom btn-sm">
                                               <i class="bi bi-people"></i>
                                            </a> --}}
                                            <form action="{{ route('admin.fitness.destroy', $class->id) }}"
                                                  method="POST"
                                                  class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="empty-state">
                                        <i class="fas fa-dumbbell text-muted mb-2"></i>
                                        <h5>Tidak ada kelas fitness</h5>
                                        <p class="text-muted">Silakan tambah kelas baru</p>
                                    </div>
                                </td>
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
