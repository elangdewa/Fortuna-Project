@extends('layouts.user')

@section('user-content')
<div class="container py-5">
    <h2 class="text-center mb-4 fw-bold">Pilih Paket Membership Anda!</h2>
    <p class="text-center mb-5 text-muted">Temukan paket yang tepat untuk mendukung perjalanan kebugaran Anda.</p>

    {{-- Tampilkan informasi membership aktif jika ada --}}
    @if(isset($active_membership))
    <div class="alert alert-info text-center">
        Anda telah memiliki membership <strong>{{ $active_membership->type->name }}</strong>
        sejak <strong>{{ $active_membership->start_date->format('d F Y') }}</strong>
        hingga <strong>{{ $active_membership->end_date->format('d F Y') }}</strong>
        ({{ $active_membership->start_date->diffInDays(now()) }} hari).
    </div>
    @endif

    <div class="row justify-content-center">
        @foreach ($types as $type)
        <div class="col-md-3 mb-4">
            <div class="card h-100 text-center shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $type->name }}</h5>
                    <p class="card-text fw-bold mb-2 text-success">Rp {{ number_format($type->price, 0, ',', '.') }}</p>
                    <hr>
                    <p class="text-muted mb-4">{{ $type->duration_in_months }} Bulan</p>

                    {{-- Tombol akan nonaktif jika sudah punya membership --}}
                    @if(!isset($active_membership))
                        <button class="btn btn-success w-100 mt-auto" data-bs-toggle="modal" data-bs-target="#modal-{{ $type->id }}">
                            Pilih Paket
                        </button>
                    @else
                        <button class="btn btn-secondary w-100 mt-auto" disabled>
                            Sudah Terdaftar
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- Modal tetap dibuat, hanya tidak akan bisa diakses jika tombol disabled --}}
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
                                <li><strong>Nama Paket:</strong> {{ $type->name }}</li>
                                <li><strong>Durasi:</strong> {{ $type->duration_in_months }} Bulan</li>
                                <li><strong>Harga:</strong> Rp {{ number_format($type->price, 0, ',', '.') }}</li>
                                <li><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::now()->format('d F Y') }}</li>
                                <li><strong>Tanggal Berakhir:</strong> {{ \Carbon\Carbon::now()->addMonths($type->duration_in_months)->format('d F Y') }}</li>
                            </ul>

                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" required id="termsCheck-{{ $type->id }}">
                                <label class="form-check-label" for="termsCheck-{{ $type->id }}">
                                    Saya setuju dengan syarat dan ketentuan
                                </label>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Konfirmasi & Bayar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
