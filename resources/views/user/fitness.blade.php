@extends('layouts.user')

@section('user-content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="fw-bold mb-1">Kelas Fitness</h1>
            <p class="text-muted mb-4">Gabung ke kelas favoritmu dan mulai perjalanan kebugaranmu hari ini!</p>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <!-- Class List -->
            <div class="row">
                @foreach($schedules as $schedule)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-img-top bg-dark-subtle" style="height: 150px;"></div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $schedule->fitnessClass->class_name }}</h5>
                            <p class="card-text mb-1">Coach {{ $schedule->coach_name ?? 'Wawan' }}</p>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-clock me-1"></i>
                                <small>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} WIB</small>
                                <i class="bi bi-calendar ms-3 me-1"></i>
                                <small>{{ __($schedule->day_of_week) }}</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                @php
                                    // Hitung kapasitas efektif dan slot tersedia
                                    $capacity = $schedule->capacity ?: $schedule->fitnessClass->capacity;
                                    $availableSlots = $capacity - $schedule->registrations_count;
                                    $isRegistered = $schedule->isRegisteredBy(Auth::id());
                                @endphp
                                
                                <small class="text-muted">
                                    @if($availableSlots > 0)
                                        Sisa <span class="fw-bold">{{ $availableSlots }}</span> dari {{ $capacity }} Kuota
                                    @else
                                        <span class="text-danger fw-bold">Kuota Penuh</span>
                                    @endif
                                </small>
                                
                                @if($isRegistered)
                                    <span class="badge bg-success">Sudah Terdaftar</span>
                                @elseif($availableSlots > 0)
                                    <form action="{{ route('fitness.register.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                        <button type="submit" class="btn btn-success btn-sm rounded-pill px-3">Pesan</button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary btn-sm rounded-pill px-3" disabled>Penuh</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- User Registration List -->
            @if(isset($userRegistrations) && $userRegistrations->count() > 0)
            <div class="mt-5">
                <h4 class="mb-3">Kelas Anda</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kelas</th>
                                <th>Hari</th>
                                <th>Waktu</th>
                                <th>Coach</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userRegistrations as $registration)
                            <tr>
                                <td>{{ $registration->fitnessClass->class_name }}</td>
                                <td>{{ __($registration->schedule->day_of_week) }}</td>
                                <td>{{ \Carbon\Carbon::parse($registration->schedule->start_time)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($registration->schedule->end_time)->format('H:i') }}</td>
                                <td>{{ $registration->schedule->coach_name ?? 'Wawan' }}</td>
                                <td>{{ \Carbon\Carbon::parse($registration->registered_at)->format('d F Y') }}</td>
                                <td><span class="badge bg-success">Aktif</span></td>
                                <td>
                                    <form action="{{ route('fitness.register.cancel', $registration->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan kelas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Batalkan</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection