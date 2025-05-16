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
                        <div class="card-body">
                            <h5 class="card-title">{{ $schedule->fitnessClass->class_name }}</h5>
                            @if($schedule->fitnessClass->description)
                                <p class="card-text text-muted mb-2 small">{{ $schedule->fitnessClass->description }}</p>
                            @endif

                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-clock me-1"></i>
                                <small>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} WIB</small>
                                <i class="bi bi-calendar ms-3 me-1"></i>
                                <small>{{ __($schedule->day_of_week) }}</small>
                            </div>

                            <div class="mb-3">
                                @if($schedule->price)
                                    <p class="mb-1"><strong>Harga: </strong>Rp {{ number_format($schedule->price, 0, ',', '.') }}</p>
                                @endif

                                @if($schedule->description)
                                    <p class="mb-1 small text-muted">{{ $schedule->description }}</p>
                                @endif
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                @php
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
                                    <span class="badge orange-badge">Sudah Terdaftar</span>
                                @elseif($availableSlots > 0)
                                    <button type="button"
                                            class="btn btn-sm rounded-pill px-3 orange-btn"
                                            onclick="startClassRegistration({{ $schedule->id }})">
                                        Pesan
                                    </button>
                                @else
                                    <button class="btn btn-secondary btn-sm rounded-pill px-3" disabled>Penuh</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>


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
                                <td>{{ \Carbon\Carbon::parse($registration->registered_at)->format('d F Y') }}</td>
                                <td><span class="badge orange-badge">Aktif</span></td>
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

<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                <h3 class="mt-3">Pembayaran Berhasil!</h3>
                <p class="mb-4">Anda telah berhasil mendaftar ke kelas ini.</p>
                <button type="button" class="btn orange-btn" onclick="window.location.reload()">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .card-body,
    .card-body .card-title,
    .card-body .card-text,
    .card-body small,
    .card-body p {
        color: #000 !important;
    }

    /* Khusus untuk teks yang ingin tetap putih */
    .card-body .text-white,
    .card-body .badge,
    .card-body .btn {
        color: #fff !important;
    }
    .orange-badge {
        background-color: #da9100 !important;
        color: white !important;
    }

    .orange-btn {
        background-color: #da9100 !important;
        color: white !important;
        border: none !important;
    }

    .spinner-border {
    width: 1rem;
    height: 1rem;
    border-width: 0.2em;
}
</style>
@endsection

@push('scripts')
<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>
function startClassRegistration(scheduleId) {
    // Show loading state
    const button = event.target;
    button.disabled = true;
    button.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';

    // Kirim request ke server
    fetch("{{ route('payments.class.registration') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            schedule_id: scheduleId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.snap_token) {
            // Pastikan window.snap sudah ada
            if (typeof window.snap !== 'undefined') {
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        console.log('Payment success:', result);
                        window.location.reload();
                    },
                    onPending: function(result) {
                        console.log('Payment pending:', result);
                        alert('Silakan selesaikan pembayaran Anda');
                        button.disabled = false;
                        button.innerHTML = 'Pesan';
                    },
                    onError: function(result) {
                        console.log('Payment error:', result);
                        alert('Pembayaran gagal, silakan coba lagi');
                        button.disabled = false;
                        button.innerHTML = 'Pesan';
                    },
                    onClose: function() {
                        console.log('Customer closed the popup without finishing the payment');
                        button.disabled = false;
                        button.innerHTML = 'Pesan';
                    }
                });
            } else {
                console.error('Snap.js is not loaded properly');
                alert('Terjadi kesalahan saat memuat pembayaran');
                button.disabled = false;
                button.innerHTML = 'Pesan';
            }
        } else {
            console.error('Server response error:', data);
            alert(data.message || 'Terjadi kesalahan sistem');
            button.disabled = false;
            button.innerHTML = 'Pesan';
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        alert('Terjadi kesalahan sistem');
        button.disabled = false;
        button.innerHTML = 'Pesan';
    });
}
</script>
@endpush
