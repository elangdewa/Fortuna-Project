<link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">
@extends('layouts.user')

@section('user-content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="fw-bold mb-1" style="color: #080808;">Kelas Fitness</h1>
                    <p class="text-muted">Gabung ke kelas favoritmu dan mulai perjalanan kebugaranmu hari ini!</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                </div>
            @endif

            <!-- Class List -->
            <div class="row">
                @foreach($schedules as $schedule)
                    @if($schedule->fitnessClass) {{-- Tambahkan pengecekan null --}}
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0 hover-card">
                            <div class="card-header border-0 bg-transparent pt-3">
                               <span class="badge" style="background-color: #da9100;">
    <i class="bi bi-calendar-event me-1"></i>
    {{ \Carbon\Carbon::parse($schedule->date)->translatedFormat('l') }}
</span>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-bold" style="color: #080808;">
                                    {{ $schedule->fitnessClass->class_name ?? 'Kelas Tidak Tersedia' }}
                                </h5>

                                @if($schedule->fitnessClass->description ?? false)
                                    <p class="card-text text-muted small mb-3">{{ $schedule->fitnessClass->description }}</p>
                                @endif

                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-1 d-flex align align-items-center">@if ($schedule->date)
    {{ \Carbon\Carbon::parse($schedule->date)->translatedFormat('d F Y') }}
@else
    Tidak ditentukan
@endif</div>
                                    <div class="me-1 d-flex align-items-center">
                                        <i class="bi bi-clock me-1" style="color: #da9100;"></i>
                                        <small>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} WIB</small>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person-fill me-1" style="color: #da9100;"></i>
                                        @php
                                            $capacity = $schedule->capacity ?: ($schedule->fitnessClass->capacity ?? 0);
                                            $availableSlots = $capacity - $schedule->registrations_count;
                                            $isRegistered = $schedule->isRegisteredBy(Auth::id());
                                        @endphp
                                        <small>{{ $availableSlots }}/{{ $capacity }}</small>
                                    </div>
                                </div>

                                @if($schedule->price)
                                    <div class="price-tag mb-3">
                                        <span class="fw-bold" style="color: #080808; font-size: 1.1rem;">Rp {{ number_format($schedule->price, 0, ',', '.') }}</span>
                                    </div>
                                @endif

                                @if($schedule->description)
                                    <p class="small text-muted mb-3">{{ $schedule->description }}</p>
                                @endif

                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    @if($isRegistered)
                                        <span class="badge" style="background-color: #080808;">
                                            <i class="bi bi-check-circle me-1"></i>Terdaftar
                                        </span>
                                    @elseif($availableSlots > 0)
                                       <button type="button"
                class="btn btn-booking rounded-pill px-4 "
                onclick="orderClass({{ $schedule->id }}, {{ $schedule->price }}, 'class_registration')">
            <i class="bi bi-calendar-plus me-1"></i>Pesan
        </button>
                                    @else
                                        <button class="btn btn-secondary rounded-pill px-3" disabled>
                                            <i class="bi bi-x-circle me-1"></i>Penuh
                                        </button>
                                    @endif

                                    <div class="text-end">
                                        @if($availableSlots > 0 && !$isRegistered)
                                            <small class="slot-label">
                                                <span class="fw-bold">{{ $availableSlots }}</span> slot tersedia
                                            </small>
                                        @elseif($availableSlots == 0)
                                            <small class="text-danger fw-bold">Kuota Penuh</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif {{-- End pengecekan null --}}
                @endforeach
            </div>

          @if(isset($userRegistrations) && $userRegistrations->count() > 0)
<div class="mt-5">
    <h4 class="mb-4" style="color: #080808;">
        <i class="bi bi-bookmark-check me-2" style="color: #da9100;"></i>Kelas Anda
    </h4>
    <div class="table-responsive card shadow-sm border-0">
        <table class="table table-hover mb-0">
            <thead style="background-color: #f9f9f9;">
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
                    @if($registration->fitnessClass && $registration->schedule) {{-- Tambahkan pengecekan null --}}
                    <tr>
                        <td class="fw-medium">{{ $registration->fitnessClass->class_name }}</td>
                        <td>{{ __($registration->schedule->day_of_week) }}</td>
                        <td>{{ \Carbon\Carbon::parse($registration->schedule->start_time)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($registration->schedule->end_time)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($registration->registered_at)->format('d F Y') }}</td>
       <td>
        @if($registration->payment_status === 'paid')
            <span class="badge" style="background-color: #198754;">Aktif</span>
        @elseif($registration->payment_status === 'unpaid')
            <span class="badge" style="background-color: #ffc107; color: #080808;">Belum Dibayar</span>
        @elseif($registration->payment_status === 'failed')
            <span class="badge" style="background-color: #dc3545;">Gagal</span>
        @endif
    </td>
                        <td>
    @if($registration->payment_status === 'unpaid')
                            <form action="{{ route('fitness.register.cancel', $registration->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan kelas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-cancel">
                                    <i class="bi bi-x-circle me-1"></i>Batalkan
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endif {{-- End pengecekan null --}}
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
        </div>
    </div>
</div>

 <!-- Modal untuk status pembayaran -->
    <div class="modal fade" id="paymentStatusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-body text-center p-5">
                    <div id="statusIcon" class="mb-4">
                        <i class="bi bi-hourglass-split text-warning" style="font-size: 4rem;"></i>
                    </div>
                    <h3 id="statusTitle" class="mb-3">Memeriksa Status Pembayaran...</h3>
                    <p id="statusMessage" class="mb-4 text-muted">Mohon tunggu, kami sedang memverifikasi pembayaran Anda.</p>
                    <div id="statusActions" class="d-none">
                        <button type="button" class="btn btn-lg px-5 btn-booking" onclick="window.location.reload()">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk sukses -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-body text-center p-5">
                    <div class="success-icon mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="mb-3">Pembayaran Berhasil!</h3>
                    <p class="mb-4 text-muted">Anda telah berhasil mendaftar ke kelas ini.</p>
                    <button type="button" class="btn btn-lg px-5 btn-booking" onclick="window.location.reload()">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<!-- Midtrans Snap -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
function orderClass(scheduleId, price) {
    const button = event.target.closest('.btn');
    const originalContent = button.innerHTML;

    button.disabled = true;
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';

    fetch("{{ route('fitness.register.store') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ schedule_id: scheduleId })
    })
    .then(res => res.json())
    .then(regRes => {
        if (!regRes.success || !regRes.registration) throw new Error('Gagal mendaftar kelas');

        return fetch("{{ route('payment.create') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                type: "class_registration",
                reference_id: regRes.registration.id,
                amount: price,
                schedule_id: scheduleId,
                class_name: regRes.registration.class_name
            })
        });
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success || !data.snapToken) throw new Error('Gagal mendapatkan Snap Token');

        window.snap.pay(data.snapToken, {
            onSuccess: function () {
                checkPaymentStatus(data.orderId);
            },
            onPending: function () {
                showToast('Silakan selesaikan pembayaran Anda', 'warning');
                resetButton(button, originalContent);
            },
            onError: function () {
                showToast('Pembayaran gagal, silakan coba lagi', 'error');
                resetButton(button, originalContent);
            },
            onClose: function () {
                resetButton(button, originalContent);
            }
        });
    })
    .catch(error => {
        console.error('Error:', error);
        showToast(error.message, 'error');
        resetButton(button, originalContent);
    });
}

function checkPaymentStatus(orderId) {
    showPaymentStatusModal();

    fetch("{{ route('payment.check', ':id') }}".replace(':id', orderId), {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            if (data.payment_status === 'paid') {
                showSuccessModal();
            } else if (data.payment_status === 'pending') {
                setTimeout(() => checkPaymentStatus(orderId), 3000);
            } else {
                showToast(data.message, 'warning');
                hidePaymentStatusModal();
            }
        } else {
            throw new Error(data.message);
        }
    })
    .catch(error => {
        console.error('Status check error:', error);
        showToast('Gagal memeriksa status: ' + error.message, 'error');
        hidePaymentStatusModal();
    });
}

function resetButton(button, originalContent) {
    button.disabled = false;
    button.innerHTML = originalContent;
}

function showPaymentStatusModal() {
    $('#paymentStatusModal').modal('show');
}

function hidePaymentStatusModal() {
    $('#paymentStatusModal').modal('hide');
}

function showSuccessModal() {
    hidePaymentStatusModal();
    $('#successModal').modal('show');
}
</script>
@endpush
