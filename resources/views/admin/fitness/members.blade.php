@extends('layouts.admin')

@section('admin-content')
<link href="{{ asset('css/tableadmin.css') }}" rel="stylesheet">


<div class="container mt-5">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>{{ $schedule->fitnessClass->class_name }}</h2>
            <p class="text-muted mb-0">
                {{ $schedule->day_of_week }},
                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -
                {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} WIB
            </p>
        </div>
        <div class="d-flex gap-2">
            <div class="stats-badge">
                <span class="badge bg-primary">
                    <i class="bi bi-people-fill me-1"></i>
                    {{ $activeMembers }}/{{ $totalCapacity }} Member
                </span>
            </div>
            <a href="{{ route('admin.fitness.schedules.index', $schedule->fitnessClass->id) }}"
               class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Member List Card -->
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Daftar Member Terdaftar</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Tanggal Daftar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $registration)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($registration->user->profile_photo)
                                            <img src="{{ asset('storage/profile_photos/' . $registration->user->profile_photo) }}"
                                                 class="rounded-circle me-2"
                                                 width="32" height="32"
                                                 alt="{{ $registration->user->name }}">
                                        @else
                                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2"
                                                 style="width: 32px; height: 32px;">
                                                {{ strtoupper(substr($registration->user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        {{ $registration->user->name }}
                                    </div>
                                </td>
                                <td>{{ $registration->user->email }}</td>
                                <td>{{ $registration->user->phone ?? '-' }}</td>
                                <td>{{ $registration->registered_at->format('d M Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-{{ $registration->status === 'active' ? 'success' : 'warning' }}">
                                        {{ ucfirst($registration->status) }}
                                    </span>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="empty-state">
                                        <i class="bi bi-people text-muted fs-1 mb-2"></i>
                                        <h6 class="text-muted">Belum ada member yang terdaftar</h6>
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

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});

</script>
@endpush
