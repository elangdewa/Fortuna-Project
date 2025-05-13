@extends('layouts.user')

@section('user-content')
<div class="container py-3 py-md-5">
    <h2 class="text-center mb-3 mb-md-4 fw-bold">Pilih Paket Membership Anda!</h2>
    <p class="text-center mb-4 mb-md-5 text-muted">Temukan paket yang tepat untuk mendukung perjalanan kebugaran Anda.</p>

    @if (session('error'))
    <div class="alert alert-danger text-center">
        {{ session('error') }}
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
    @endif

    @if(isset($active_membership))
    <div class="alert alert-info text-center">
        Anda telah memiliki membership <strong>{{ $active_membership->type->name }}</strong>
        sejak <strong>{{ $active_membership->start_date->format('d F Y') }}</strong>
        hingga <strong>{{ $active_membership->end_date->format('d F Y') }}</strong>
        ({{ $active_membership->start_date->diffInDays(now()) }} hari).
    </div>
    @endif

    @if(!isset($active_membership))
    <div class="row justify-content-center g-3">
        @forelse ($types as $type)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100 text-center custom-card">
                <div class="card-body p-3 p-md-4">
                    <h5 class="card-title mb-3">{{ $type->name }}</h5>
                   
                    <hr class="my-3">
                  
                    <p class="card-text fw-bold mb-2 text-dark">Rp {{ number_format($type->price, 0, ',', '.') }}</p>
                    @if (!isset($active_membership))
                    <button class="btn btn-custom w-100 mt-auto py-2" data-bs-toggle="modal" data-bs-target="#modal-{{ $type->id }}">
                        Pilih Paket
                    </button>
                    @else
                        <button class="btn btn-secondary w-100 mt-auto py-2" disabled>
                            Sudah Aktif
                        </button>
                    @endif
                </div>
            </div>
        </div>

        @if (!isset($active_membership))
        <div class="modal fade" id="modal-{{ $type->id }}" tabindex="-1" aria-labelledby="modalLabel-{{ $type->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('memberships.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="membership_type" value="{{ $type->id }}">

                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel-{{ $type->id }}">Konfirmasi Pemilihan Paket</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>

                        <div class="modal-body">
                            <ul class="list-unstyled">
                                <li class="mb-2"><strong>Nama Paket:</strong> {{ $type->name }}</li>
                                <li class="mb-2"><strong>Durasi:</strong> {{ $type->duration_in_months }} Bulan</li>
                                <li class="mb-2"><strong>Harga:</strong> Rp {{ number_format($type->price, 0, ',', '.') }}</li>
                                <li class="mb-2"><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::now()->format('d F Y') }}</li>
                                <li class="mb-2"><strong>Tanggal Berakhir:</strong> {{ \Carbon\Carbon::now()->addMonths($type->duration_in_months)->format('d F Y') }}</li>
                            </ul>

                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" required id="termsCheck-{{ $type->id }}">
                                <label class="form-check-label" for="termsCheck-{{ $type->id }}">
                                    Saya setuju dengan syarat dan ketentuan
                                </label>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-custom">Konfirmasi & Bayar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
        @empty
        <div class="col-12">
            <p class="text-center text-muted">Tidak ada paket tersedia.</p>
        </div>
        @endforelse
    </div>
    @endif
</div>

<style>
    /* Custom Card Style - Responsif */
    .custom-card {
        width: 100%;
        min-height: 280px;
        background: white;
        border-radius: 10px;
        transition: all 0.3s ease;
        box-shadow: inset 0 -3em 3em rgba(0,0,0,0.1),
                    0 0 0 2px rgb(190, 190, 190),
                    0.3em 0.3em 1em rgba(0,0,0,0.3);
    }
    
    .custom-card:hover {
        transform: translateY(-5px);
        box-shadow: inset 0 -3em 3em rgba(0,0,0,0.1),
                    0 0 0 2px rgb(190, 190, 190),
                    0.5em 0.5em 1.5em rgba(0,0,0,0.3);
    }
    
    .custom-card .card-body {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .btn-custom {
        background-color: #da9100;
        color: white;
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-custom:hover {
        background-color: #c08200;
        color: white;
        transform: translateY(-2px);
    }
    
    /* Teks hitam untuk semua device */
    .card-title, 
    .card-text.text-dark, 
    .text-dark {
        color: #000 !important;
    }
    
    /* Responsif untuk teks */
    @media (max-width: 576px) {
        .card-title {
            font-size: 1.1rem;
        }
        .card-text, .text-dark {
            font-size: 0.9rem;
        }
    }
    
    /* Padding untuk mobile */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.25rem !important;
        }
    }
</style>
@endsection