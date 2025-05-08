@extends('layouts.app')

@section('content')
<link href="{{ asset('css/member.css') }}" rel="stylesheet">
@include('layouts.sidenavbar')

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Jadwal Kelas: {{ $class->class_name }}</h2>
        <a href="{{ route('admin.fitness.index') }}" class="btn btn-secondary">
            Kembali ke Daftar Kelas
        </a>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addScheduleModal">
            Tambah Jadwal
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Harga</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($class->schedules as $schedule)
                            <tr>
                                <td>{{ $schedule->day_of_week }}</td>
                                <td>{{ $schedule->start_time }}</td>
                                <td>{{ $schedule->end_time }}</td>
                                <td>Rp {{ number_format($schedule->price, 0, ',', '.') }}</td>
                                <td>{{ $schedule->description }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-btn"
                                        data-id="{{ $schedule->id }}"
                                        data-day_of_week="{{ $schedule->day_of_week }}"
                                        data-start_time="{{ $schedule->start_time }}"
                                        data-end_time="{{ $schedule->end_time }}"
                                        data-price="{{ $schedule->price }}"
                                        data-description="{{ $schedule->description }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editScheduleModal">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.fitness.schedules.destroy', $schedule->id) }}" 
                                        method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Hapus jadwal ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada jadwal untuk kelas ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Jadwal -->
<div class="modal fade" id="addScheduleModal" tabindex="-1" aria-labelledby="addScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addScheduleModalLabel">Tambah Jadwal Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.fitness.schedules.store', $class->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="day_of_week" class="form-label">Hari</label>
                        <select class="form-select" id="day_of_week" name="day_of_week" required>
                            <option value="">Pilih Hari</option>
                            <option value="Monday">Senin</option>
                            <option value="Tuesday">Selasa</option>
                            <option value="Wednesday">Rabu</option>
                            <option value="Thursday">Kamis</option>
                            <option value="Friday">Jumat</option>
                            <option value="Saturday">Sabtu</option>
                            <option value="Sunday">Minggu</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="start_time" class="form-label">Jam Mulai</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_time" class="form-label">Jam Selesai</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Harga (Rp)</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi (Opsional)</label>
                        <textarea class="form-control" id="description" name="description" rows="2"></textarea>
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

<!-- Modal Edit Jadwal -->
<div class="modal fade" id="editScheduleModal" tabindex="-1" aria-labelledby="editScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editScheduleModalLabel">Edit Jadwal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editScheduleForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit_day_of_week" class="form-label">Hari</label>
                        <select class="form-select" id="edit_day_of_week" name="day_of_week" required>
                            <option value="Monday">Senin</option>
                            <option value="Tuesday">Selasa</option>
                            <option value="Wednesday">Rabu</option>
                            <option value="Thursday">Kamis</option>
                            <option value="Friday">Jumat</option>
                            <option value="Saturday">Sabtu</option>
                            <option value="Sunday">Minggu</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_start_time" class="form-label">Jam Mulai</label>
                        <input type="time" class="form-control" id="edit_start_time" name="start_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_end_time" class="form-label">Jam Selesai</label>
                        <input type="time" class="form-control" id="edit_end_time" name="end_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_price" class="form-label">Harga (Rp)</label>
                        <input type="number" class="form-control" id="edit_price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="2"></textarea>
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
        
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const day = this.getAttribute('data-day_of_week');
                const start = this.getAttribute('data-start_time');
                const end = this.getAttribute('data-end_time');
                const price = this.getAttribute('data-price');
                const desc = this.getAttribute('data-description');

                // Set form values
                document.getElementById('edit_day_of_week').value = day;
                document.getElementById('edit_start_time').value = start;
                document.getElementById('edit_end_time').value = end;
                document.getElementById('edit_price').value = price;
                document.getElementById('edit_description').value = desc;

                // Set form action
                document.getElementById('editScheduleForm').action = `/admin/fitness/schedules/${id}`;
            });
        });
    });
</script>
@endpush