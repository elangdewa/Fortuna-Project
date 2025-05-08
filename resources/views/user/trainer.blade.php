@extends('layouts.user')

@section('user-content')

<div class="container mt-5">
    <h1 class="text-center mb-4">Pilih Personal Trainer Terbaik!</h1>
    <p class="text-center mb-5">Pilih personal trainer yang sesuai dengan kebutuhan dan tujuan fitnessmu untuk hasil yang lebih maksimal</p>

    <div class="row">
        @foreach($trainers as $trainer)
        <div class="col-md-6 mb-4">
            <div class="card trainer-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h3 class="card-title">{{ $loop->iteration }}. {{ $trainer->name }}</h3>
                            <h5 class="card-subtitle mb-2 text-muted">Spesialisasi</h5>
                        </div>
                        <form action="{{ route('user.trainer-orders.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="trainer_id" value="{{ $trainer->id }}">
                            <button type="submit" class="btn btn-outline-primary">Pilih Trainer</button>
                        </form>
                    </div>
                    <p class="trainer-experience">{{ $trainer->experience }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    .trainer-card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: none;
        transition: transform 0.3s;
        padding: 20px;
    }

    .trainer-card:hover {
        transform: translateY(-5px);
    }

    .card-title {
        font-weight: bold;
        color: #333;
    }

    .card-subtitle {
        font-weight: 500;
        color: #6c757d;
    }

    .btn-outline-primary {
        border-radius: 20px;
        padding: 8px 20px;
    }

    .trainer-experience {
    color: #000 !important;
}
.card-body p.trainer-experience {
    color: #000 !important;
}

</style>


@endsection