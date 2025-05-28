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
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 hover-card">
                        <div class="card-header border-0 bg-transparent pt-3">
                            <span class="badge" style="background-color: #da9100;">
                                <i class="bi bi-calendar-event me-1"></i>{{ __($schedule->day_of_week) }}
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #080808;">{{ $schedule->fitnessClass->class_name }}</h5>

                            @if($schedule->fitnessClass->description)
                                <p class="card-text text-muted small mb-3">{{ $schedule->fitnessClass->description }}</p>
                            @endif

                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3 d-flex align-items-center">
                                    <i class="bi bi-clock me-1" style="color: #da9100;"></i>
                                    <small>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} WIB</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person-fill me-1" style="color: #da9100;"></i>
                                    @php
                                        $capacity = $schedule->capacity ?: $schedule->fitnessClass->capacity;
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
        class="btn rounded-pill px-4 btn-booking"
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
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-5">
                <div class="success-icon mb-4">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                </div>
                <h3 class="mb-3" style="color: #080808;">Pembayaran Berhasil!</h3>
                <p class="mb-4 text-muted">Anda telah berhasil mendaftar ke kelas ini.</p>
                <button type="button" class="btn btn-lg px-5 btn-booking" onclick="window.location.reload()">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Payment Status Modal -->
<div class="modal fade" id="paymentStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-5">
                <div id="statusIcon" class="mb-4">
                    <i class="bi bi-hourglass-split text-warning" style="font-size: 4rem;"></i>
                </div>
                <h3 id="statusTitle" class="mb-3" style="color: #080808;">Memeriksa Status Pembayaran...</h3>
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

<style>
    /* Main color scheme */
    :root {
        --primary-color: #da9100;
        --dark-color: #080808;
        --light-gray: #f5f5f5;
        --medium-gray: #e0e0e0;
    }

    /* General styling */
    body {
        color: var(--dark-color);
    }

    /* Card styling */
    .hover-card {
        transition: all 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
        background-color: #ffffff;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(218, 145, 0, 0.1) !important;
    }

    /* Button styling */
    .btn-booking {
        background-color: var(--primary-color);
        color: white;
        border: none;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .btn-booking:hover {
        background-color: #c48200;
        color: white;
        box-shadow: 0px 4px 10px rgba(218, 145, 0, 0.3);
    }

    .btn-cancel {
        color: #dc3545;
        background-color: rgba(220, 53, 69, 0.1);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background-color: rgba(220, 53, 69, 0.2);
    }

    /* Table styling */
    table.table {
        border-collapse: separate;
        border-spacing: 0;
    }

    table.table thead th {
        border-bottom: 2px solid var(--medium-gray);
        color: var(--dark-color);
        font-weight: 600;
        padding: 1rem;
    }

    table.table tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--medium-gray);
    }

    /* Slot indicator */
    .slot-label {
        color: var(--dark-color);
        opacity: 0.7;
    }

    /* Price tag */
    .price-tag {
        position: relative;
        display: inline-block;
    }

    /* Loading spinner */
    .spinner-border {
        width: 1rem;
        height: 1rem;
        border-width: 0.2em;
    }

    /* Success modal styling */
    .success-icon {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background-color: rgba(25, 135, 84, 0.1);
    }

    /* Dark mode considerations - keep important text visible */
    .card-body,
    .card-body .card-title,
    .card-body .card-text,
    .card-body small,
    .card-body p {
        color: var(--dark-color) !important;
    }
</style>
@endsection

@push('scripts')
<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}">
</script>

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
        body: JSON.stringify({
            schedule_id: scheduleId
        })
    })
    .then(response => response.json())
    .then(regRes => {
        if (!regRes.success || !regRes.registration) throw new Error('Gagal mendaftar kelas');
        // 2. Lanjutkan ke pembayaran
        return fetch("{{ route('payment.create') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                type: "class_registration",
                reference_id: regRes.registration.id,
                amount: price
            })
        });
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.snapToken) {
         window.snap.pay(data.snapToken, {
    onSuccess: function(result) {
        checkPaymentStatus(data.orderId);
    },
    onPending: function(result) {
        alert('Pembayaran belum selesai. Silakan selesaikan pembayaran.');
    },
    onError: function(result) {
        alert('Terjadi kesalahan saat pembayaran.');
    },
    onClose: function() {
        alert('Anda menutup pembayaran tanpa menyelesaikannya.');
    }
});
        } else {
            alert(data.error || 'Gagal memulai pembayaran.');
        }
    })
    .catch(error => {
        alert(error.message || 'Terjadi kesalahan sistem');
    })
    .finally(() => {
        button.disabled = false;
        button.innerHTML = originalContent;
    });
}
function checkPaymentStatus(orderId) {
    // Show status modal
    showPaymentStatusModal(orderId);

    // Check status via manual status check
    fetch(`{{ url('/payments/check-status') }}/${orderId}`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        if (response.redirected) {
            // Handle redirect response
            window.location.href = response.url;
        } else {
            // Handle any other response
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Status check error:', error);
        showToast('Gagal memeriksa status pembayaran', 'error');
        $('#paymentStatusModal').modal('hide');
    });
}

function showPaymentStatusModal(orderId) {
    const modal = $('#paymentStatusModal');
    const statusIcon = $('#statusIcon');
    const statusTitle = $('#statusTitle');
    const statusMessage = $('#statusMessage');
    const statusActions = $('#statusActions');

    // Reset to loading state
    statusIcon.html('<i class="bi bi-hourglass-split text-warning" style="font-size: 4rem;"></i>');
    statusTitle.text('Memeriksa Status Pembayaran...');
    statusMessage.text('Mohon tunggu, kami sedang memverifikasi pembayaran Anda.');
    statusActions.addClass('d-none');

    modal.modal('show');

    // Check status every 3 seconds
    const statusInterval = setInterval(() => {
        fetch(`{{ url('/payments/check-status') }}/${orderId}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (response.redirected) {
                clearInterval(statusInterval);
                window.location.href = response.url;
            }
        })
        .catch(error => {
            console.error('Status check error:', error);
            clearInterval(statusInterval);
        });
    }, 3000);

    // Stop checking after 5 minutes
    setTimeout(() => {
        clearInterval(statusInterval);
        statusIcon.html('<i class="bi bi-clock text-warning" style="font-size: 4rem;"></i>');
        statusTitle.text('Pembayaran Membutuhkan Waktu');
        statusMessage.text('Pembayaran Anda sedang diproses. Silakan cek kembali dalam beberapa menit.');
        statusActions.removeClass('d-none');
    }, 300000); // 5 minutes
}

// Toast notification function
function showToast(message, type = 'info') {
    // Check if toast container exists
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }

    // Create toast element
    const toastId = 'toast-' + Date.now();
    const toast = document.createElement('div');
    toast.id = toastId;
    toast.className = `toast align-items-center text-white border-0`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');

    // Set background color based on type
    switch (type) {
        case 'success':
            toast.style.backgroundColor = '#198754';
            break;
        case 'error':
            toast.style.backgroundColor = '#dc3545';
            break;
        case 'warning':
            toast.style.backgroundColor = '#ffc107';
            toast.className = toast.className.replace('text-white', 'text-dark');
            break;
        default:
            toast.style.backgroundColor = '#0d6efd';
    }

    // Toast content
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;

    // Append toast to container
    toastContainer.appendChild(toast);

    // Initialize and show toast
    const bsToast = new bootstrap.Toast(toast, {
        animation: true,
        autohide: true,
        delay: 5000
    });

    bsToast.show();

    // Remove toast element after it's hidden
    toast.addEventListener('hidden.bs.toast', function () {
        toast.remove();
    });
}
</script>
@endpush
