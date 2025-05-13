@extends('layouts.user')

@section('user-content')
<div class="container py-5">
    <!-- Membership Section -->
    <section class="mb-5">
        <h2 class="text-center mb-4">Paket Membership</h2>
        <div class="row justify-content-center g-4">
            @foreach($memberships->take(3) as $membership)
            <div class="col-md-4">
                <div class="card membership-card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $membership->name }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Rp {{ number_format($membership->price, 0, ',', '.') }}</h6>
                        <p class="card-text">Durasi: {{ $membership->duration_in_months }} Bulan</p>
                        <a href="{{ route('user.member') }}" class="btn orange-btn mt-auto">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Fitness Classes Section -->
    <section class="mb-5">
        <h2 class="text-center mb-4">Kelas Fitness</h2>
        <div class="row justify-content-center g-4">
            @foreach($schedules->take(3) as $schedule)
            <div class="col-md-4">
                <div class="card fitness-card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $schedule->fitnessClass->class_name }}</h5>
                        @if($schedule->fitnessClass->description)
                            <p class="card-text text-muted mb-2 small">{{ $schedule->fitnessClass->description }}</p>
                        @endif
                        <div class="schedule-info">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-clock me-2"></i>
                                <small>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} WIB</small>
                                <i class="bi bi-calendar ms-3 me-2"></i>
                                <small>{{ __($schedule->day_of_week) }}</small>
                            </div>
                        </div>

                        @php
                            $capacity = $schedule->capacity ?: $schedule->fitnessClass->capacity;
                            $availableSlots = $capacity - $schedule->registrations_count;
                        @endphp

                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    @if($availableSlots > 0)
                                        Sisa <span class="fw-bold">{{ $availableSlots }}</span> dari {{ $capacity }} Kuota
                                    @else
                                        <span class="text-danger fw-bold">Kuota Penuh</span>
                                    @endif
                                </small>
                                <a href="{{ route('user.fitness') }}" class="btn btn-sm orange-btn rounded-pill px-3">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Personal Trainers Section -->
    <section class="mb-5">
        <h2 class="text-center mb-4">Personal Trainer</h2>
        <div class="row justify-content-center g-4">
            @foreach($trainers->take(3) as $trainer)
            <div class="col-md-4">
                <div class="card trainer-card h-100">
                    @if($trainer->photo)
                        <img src="{{ asset('storage/'.$trainer->photo) }}" class="card-img-top trainer-img" alt="{{ $trainer->name }}">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $trainer->name }}</h5>
                        <p class="card-text">{{ Str::limit($trainer->specialization, 100) }}</p>
                        <a href="{{ route('user.trainer') }}" class="btn orange-btn mt-auto">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>

<style>
/* Common Card Styles */
.card {
    transition: all 0.3s ease;
    border: none;
    height: 100%;
}

/* Membership Card Styles */
.membership-card {
    background: white;
    border-radius: 10px;
    box-shadow: inset 0 -3em 3em rgba(0,0,0,0.1),
                0 0 0 2px rgb(190, 190, 190),
                0.3em 0.3em 1em rgba(0,0,0,0.3);
}

.membership-card:hover {
    transform: translateY(-5px);
    box-shadow: inset 0 -3em 3em rgba(0,0,0,0.1),
                0 0 0 2px rgb(190, 190, 190),
                0.5em 0.5em 1.5em rgba(0,0,0,0.3);
}

/* Fitness Card Styles */
.fitness-card {
    border-radius: 15px;
    background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.fitness-card:hover {
    transform: translateY(-5px);
}

.fitness-card .bi {
    color: #da9100;
}

.schedule-info {
    margin: 15px 0;
    padding: 10px;
    background: rgba(218, 145, 0, 0.1);
    border-radius: 8px;
}

/* Trainer Card Styles */
.trainer-card {
    border-radius: 10px;
    background: white;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
}

.trainer-card:hover {
    transform: translateY(-5px);
}

.trainer-img {
    height: 200px;
    object-fit: cover;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

/* Button Styles */
.orange-btn {
    background-color: #da9100;
    color: white;
    border: none;
    transition: all 0.3s ease;
}

.orange-btn:hover {
    background-color: #b77a00;
    color: white;
    transform: translateY(-2px);
}

/* Typography */
h2 {
    color: #080808;
    font-weight: 600;
    margin-bottom: 1.5rem;
}

.card-title {
    color: #333;
    font-weight: 600;
}

.card-text {
    color: #666;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .card {
        margin-bottom: 1rem;
    }

    .card-body {
        padding: 1.25rem;
    }

    h2 {
        font-size: 1.5rem;
    }
}
</style>
@endsection
