@extends('layouts.admin')

@section('admin-content')
<link href="{{ asset('css/tableadmin.css') }}" rel="stylesheet">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Jadwal Kelas: {{ $class->class_name }}</h2>
        <a href="{{ route('admin.fitness.index') }}" class="btn btn-secondary">Kembali ke Daftar Kelas</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>Jadwal Kelas</strong>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addScheduleModal">
                Tambah Jadwal
            </button>
        </div>

        <div class="d-flex justify-content-between mb-3">


    
</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Hari</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Harga</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($class->schedules as $schedule)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($schedule->date)->format('d F Y') }}</td>
                                <td>{{ $schedule->day_of_week }}</td>
                                <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                                <td>Rp {{ number_format($schedule->price, 0, ',', '.') }}</td>
                                <td>{{ $schedule->description }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.fitness.schedule.members', $schedule->id) }}"
                                           class="btn btn-sm btn-outline-success"
                                           title="Lihat Member">
                                            <i class="bi bi-people"></i>
                                        </a>

                                        <button type="button"
                                            class="btn btn-sm btn-outline-primary edit-btn"
                                            data-id="{{ $schedule->id }}"
                                            data-date="{{ $schedule->date }}"
                                            data-day_of_week="{{ $schedule->day_of_week }}"
                                            data-start_time="{{ $schedule->start_time }}"
                                            data-end_time="{{ $schedule->end_time }}"
                                            data-price="{{ $schedule->price }}"
                                            data-description="{{ $schedule->description }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editScheduleModal">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <form action="{{ route('admin.fitness.schedules.destroy', $schedule->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada jadwal.</td>
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
            <form action="{{ route('admin.fitness.schedules.store', $class->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                <div class="mb-3">
    <label for="date" class="form-label">Tanggal</label>
    <input type="date" class="form-control" id="date" name="date" required onchange="updateDayPreview()">
</div>

<div class="mb-3">
    <label class="form-label">Hari</label>
    <input type="text" class="form-control" id="day_preview" readonly>
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
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Jadwal -->
<div class="modal fade" id="editScheduleModal" tabindex="-1" aria-labelledby="editScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editScheduleForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                 <div class="mb-3">
    <label for="date" class="form-label">Tanggal</label>
    <input type="date" class="form-control" id="date" name="date" required onchange="updateDayPreview()">
</div>

<div class="mb-3">
    <label class="form-label">Hari</label>
    <input type="text" class="form-control" id="day_preview" readonly>
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
                        <label for="edit_price" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="edit_price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.edit-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById('edit_date').value = this.dataset.date;
                document.getElementById('edit_day_of_week').value = this.dataset.day_of_week;
                document.getElementById('edit_start_time').value = this.dataset.start_time;
                document.getElementById('edit_end_time').value = this.dataset.end_time;
                document.getElementById('edit_price').value = this.dataset.price;
                document.getElementById('edit_description').value = this.dataset.description;

                document.getElementById('editScheduleForm').action =
                    `/admin/fitness/schedules/${this.dataset.id}`;
            });
        });
    });

    function updateDayPreview() {
    const dateInput = document.getElementById('date');
    const dayInput = document.getElementById('day_preview');
    const value = dateInput.value;

    if (!value) {
        dayInput.value = '';
        return;
    }

    // Convert tanggal ke nama hari (dalam bahasa Indonesia)
    const options = { weekday: 'long' };
    const dayName = new Date(value).toLocaleDateString('id-ID', options);
    dayInput.value = dayName.charAt(0).toUpperCase() + dayName.slice(1);
}

// Jalankan sekali saat halaman dimuat
document.addEventListener('DOMContentLoaded', updateDayPreview);
</script>
@endpush
