@extends('layouts.user')

@section('user-content')
<div class="container py-5">
  
   <section class="mb-5">
    <div class="section-header membership-header">
        <h2 class="text-center mb-4">Paket Membership</h2>
        <div class="section-divider membership-divider"></div>
    </div>
    <div class="row justify-content-center g-4">
        @foreach($memberships->take(3) as $membership)
        <div class="col-md-4">
            <div class="card membership-card h-100">
                <div class="card-header membership-header">
                    <h5 class="card-title mb-0">{{ $membership->name }}</h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="price-tag">
                        <h4>Rp {{ number_format($membership->price, 0, ',', '.') }}</h4>
                    </div>
                    <div class="membership-features">
                        <p class="card-text">
                            <i class="bi bi-calendar-check"></i>
                            Durasi:  {{ $membership->duration_in_months }} Bulan
                        </p>
                    </div>
                    <a href="{{ route('user.member') }}" class="btn membership-btn mt-auto">Lihat Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

    <!-- Fitness Classes Section -->
    <section class="mb-5">
        <div class="section-header fitness-header">
            <h2 class="text-center mb-4">Kelas Fitness</h2>
            <div class="section-divider fitness-divider"></div>
        </div>
        <div class="row justify-content-center g-4">
            @foreach($schedules->take(3) as $schedule)
            <div class="col-md-4">
                <div class="card fitness-card h-100">
                    <div class="fitness-ribbon">
                        <span>{{ __($schedule->day_of_week) }}</span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $schedule->fitnessClass->class_name }}</h5>
                        @if($schedule->fitnessClass->description)
                            <p class="card-text text-muted mb-3 small">{{ $schedule->fitnessClass->description }}</p>
                        @endif
                        <div class="schedule-info">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-clock me-2"></i>
                                <span>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} WIB</span>
                            </div>
                        </div>

                        @php
                            $capacity = $schedule->capacity ?: $schedule->fitnessClass->capacity;
                            $availableSlots = $capacity - $schedule->registrations_count;
                            $percentFilled = 100 - (($availableSlots / $capacity) * 100);
                        @endphp

                        <div class="mt-auto">
                            <div class="capacity-wrapper mb-3">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $percentFilled }}%"
                                        aria-valuenow="{{ $percentFilled }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    @if($availableSlots > 0)
                                        Sisa <span class="fw-bold">{{ $availableSlots }}</span> dari {{ $capacity }} Kuota
                                    @else
                                        <span class="text-danger fw-bold">Kuota Penuh</span>
                                    @endif
                                </small>
                            </div>
                            <a href="{{ route('user.fitness') }}" class="btn fitness-btn">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Personal Trainers Section -->
   <section class="mb-5">
    <div class="section-header trainer-header">
        <h2 class="text-center mb-4">Personal Trainer</h2>
        <div class="section-divider trainer-divider"></div>
    </div>
    <div class="row justify-content-center g-4">
        @foreach($trainers->take(3) as $trainer)
        <div class="col-md-4">
            <div class="card trainer-card h-100">
                @if($trainer->photo)
                    <div class="trainer-img-wrapper">
                        <img src="{{ asset('storage/'.$trainer->photo) }}" class="card-img-top trainer-img" alt="{{ $trainer->name }}">
                        <div class="trainer-overlay">
                            <h5 class="trainer-overlay-name">{{ $trainer->name }}</h5>
                        </div>
                    </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $trainer->name }}</h5>
                    <div class="trainer-specialty">
                        <p><i class="bi bi-star-fill"></i> {{ $trainer->experience }} </p>

                    </div>
                    <a href="{{ route('user.trainer') }}" class="btn trainer-btn mt-auto">Lihat Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
</div>

<style>
/* Common Styles */
.section-header {
    position: relative;
    text-align: center;
    margin-bottom: 2.5rem;
}

.section-divider {
    height: 4px;
    width: 80px;
    margin: 0 auto;
    border-radius: 2px;
}

.card {
    transition: all 0.3s ease;
    border: none;
    overflow: hidden;
    height: 100%;
}

/* Section-specific dividers */
.membership-divider {
    background: linear-gradient(90deg, #fdc830, #f37335);
}

.fitness-divider {
    background: linear-gradient(90deg, #11998e, #38ef7d);
}

.trainer-divider {
    background: linear-gradient(90deg, #8e2de2, #4a00e0);
}

/* Membership Card Styles */
.membership-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    position: relative;
}

.membership-card .card-header {
    background: linear-gradient(135deg, #fdc830, #f37335);
    color: white;
    text-align: center;
    padding: 1.5rem 1rem;
    border-bottom: none;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}

.membership-card .card-title {
    font-weight: 700;
    letter-spacing: 0.5px;
}

.price-tag {
    text-align: center;
    margin: 1rem 0;
}

.price-tag h4 {
    font-weight: 700;
    color: #f37335;
}

.membership-features {
    background-color: rgba(253, 200, 48, 0.1);
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
}

.membership-features i {
    color: #f37335;
    margin-right: 0.5rem;
}

.membership-btn {
    background: linear-gradient(135deg, #fdc830, #f37335);
    color: white;
    border-radius: 30px;
    font-weight: 600;
    padding: 0.6rem 1.5rem;
    transition: all 0.3s ease;
}

.membership-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(243, 115, 53, 0.4);
    color: white;
}

.membership-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
}

/* Fitness Card Styles */
.fitness-card {
    border-radius: 15px;
    background: white;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    position: relative;
}

.fitness-ribbon {
    position: absolute;
    top: 15px;
    right: -25px;
    transform: rotate(45deg);
    background: linear-gradient(135deg, #11998e, #38ef7d);
    color: white;
    font-size: 0.8rem;
    font-weight: 600;
    padding: 5px 25px;
    z-index: 1;
}

.fitness-card .card-title {
    color: #11998e;
    font-weight: 700;
    margin-bottom: 0.8rem;
}

.schedule-info {
    background: rgba(17, 153, 142, 0.08);
    padding: 12px;
    border-radius: 10px;
    margin: 1rem 0;
}

.schedule-info i {
    color: #38ef7d;
}

.schedule-info span {
    font-weight: 600;
    color: #333;
}

.capacity-wrapper {
    margin-top: 1rem;
}

.progress {
    height: 8px;
    background-color: #eee;
    border-radius: 4px;
    overflow: hidden;
}

.progress-bar {
    background: linear-gradient(90deg, #11998e, #38ef7d);
}

.fitness-btn {
    background: linear-gradient(135deg, #11998e, #38ef7d);
    color: white;
    border-radius: 30px;
    font-weight: 600;
    padding: 0.6rem 1.5rem;
    width: 100%;
    transition: all 0.3s ease;
}

.fitness-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(17, 153, 142, 0.4);
    color: white;
}

.fitness-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
}

/* Trainer Card Styles */
.trainer-card {
    border-radius: 12px;
    background: white;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    position: relative;
}

.trainer-img-wrapper {
    position: relative;
    overflow: hidden;
}

.trainer-img {
    height: 250px;
    width: 100%;
    object-fit: cover;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    transition: transform 0.5s ease;
}

.trainer-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(0deg, rgba(74, 0, 224, 0.8), transparent);
    padding: 20px 15px;
    transition: all 0.3s ease;
}

.trainer-overlay-name {
    color: white;
    margin: 0;
    font-weight: 700;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    transform: translateY(20px);
    opacity: 0;
    transition: all 0.3s ease;
}

.trainer-card:hover .trainer-overlay-name {
    transform: translateY(0);
    opacity: 1;
}

.trainer-card:hover .trainer-img {
    transform: scale(1.05);
}

.trainer-card .card-title {
    color: #8e2de2;
    font-weight: 700;
    margin-bottom: 0.8rem;
}

.trainer-specialty {
    background: rgba(142, 45, 226, 0.08);
    padding: 12px;
    border-radius: 10px;
    margin-bottom: 1.5rem;
}

.trainer-specialty i {
    color: #8e2de2;
    margin-right: 0.5rem;
}

.trainer-btn {
    background: linear-gradient(135deg, #8e2de2, #4a00e0);
    color: white;
    border-radius: 30px;
    font-weight: 600;
    padding: 0.6rem 1.5rem;
    transition: all 0.3s ease;
}

.trainer-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(142, 45, 226, 0.4);
    color: white;
}

.trainer-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
}

/* Responsive Styles */
@media (max-width: 768px) {
    .fitness-ribbon {
        right: -35px;
        font-size: 0.7rem;
    }

    .trainer-img {
        height: 200px;
    }

    .section-divider {
        width: 60px;
        height: 3px;
    }
}

@media (max-width: 576px) {
    .card-body {
        padding: 1.25rem;
    }

    h2 {
        font-size: 1.5rem;
    }

    .price-tag h4 {
        font-size: 1.2rem;
    }

    .membership-features, .schedule-info, .trainer-specialty {
        padding: 10px;
    }
}
</style>
@endsection
