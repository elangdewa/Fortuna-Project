<link rel="stylesheet" href="{{ asset('css/alluser.css') }}">
@extends('layouts.user')

@section('user-content')
<div class="container-fluid px-4 py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh;">
    <!-- Header Section -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-primary-custom mb-3">Personal Trainer</h1>
        <p class="lead text-muted">Temukan trainer terbaik untuk mencapai tujuan fitness Anda</p>
    </div>

    <!-- Tab Navigation -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <ul class="nav nav-pills nav-fill custom-nav-pills" id="trainerTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active custom-nav-link" id="choose-tab" data-bs-toggle="tab" data-bs-target="#choose-trainer" type="button" role="tab">
                        <i class="bi bi-person-add me-2"></i>
                        <span class="nav-text">Pilih Trainer</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link custom-nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#my-orders" type="button" role="tab">
                        <i class="bi bi-list-columns-reverse me-2"></i>
                        <span class="nav-text">Pesanan Saya</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="trainerTabsContent">
        <!-- Tab 1: Pilih Trainer -->
        <div class="tab-pane fade show active" id="choose-trainer" role="tabpanel">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="text-center mb-5">
                        <h2 class="fw-bold text-dark-custom mb-3">Pilih Personal Trainer Terbaik!</h2>
                        <p class="text-muted fs-5">Pilih personal trainer yang sesuai dengan kebutuhan dan tujuan fitnessmu untuk hasil yang lebih maksimal</p>
                    </div>

                    <div class="row g-4">
                        @foreach($trainers as $trainer)
                        <div class="col-lg-6 col-xl-4">
                            <div class="card trainer-card h-100">
                              <div class="card-header bg-dark text-white text-center">
    <h4 class="mb-0 fw-bold">#{{ $loop->iteration }}</h4>
</div>
                                <div class="card-body d-flex flex-column">
                                    <div class="text-center mb-4">
                                        <div class="trainer-avatar mb-3">
                                            <i class="bi bi-person-circle display-1 text-primary-custom"></i>
                                        </div>
                                        <h3 class="card-title fw-bold text-dark-custom mb-2">{{ $trainer->name }}</h3>
                                        <div class="specialization-badge mb-3">
                                            <span class="badge bg-light text-primary-custom fs-6 px-3 py-2">
                                                <i class="bi bi-award me-1"></i>{{ $trainer->specialization }}
                                            </span>
                                        </div>
                                        <div class="experience-info">
                                            <i class="bi bi-clock-history text-primary-custom me-2"></i>
                                            <span class="fw-semibold text-dark-custom">{{ $trainer->experience }}</span>
                                        </div>
                                    </div>
                                    <div class="mt-auto">
                                        <button type="button" class=" btn-primary-custom w-100 py-3 fw-semibold" data-bs-toggle="modal" data-bs-target="#orderModal-{{ $trainer->id }}">
                                            <i class="bi bi-person-check me-2"></i>Pilih Trainer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal untuk setiap trainer -->
                        <div class="modal fade" id="orderModal-{{ $trainer->id }}" tabindex="-1" aria-labelledby="orderModalLabel-{{ $trainer->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content custom-modal">
                                   <div class="modal-header bg-dark text-white">
    <h5 class="modal-title fw-bold" id="orderModalLabel-{{ $trainer->id }}">
        <i class="bi bi-person-check me-2 text-white"></i>Pesan Trainer {{ $trainer->name }}
    </h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
                                    <div class="modal-body p-4">
                                        <form id="trainerForm-{{ $trainer->id }}">
                                            @csrf
                                            <input type="hidden" name="trainer_id" value="{{ $trainer->id }}">

                                            <div class="row g-4">
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold text-dark-custom">
                                                        <i class="bi bi-calendar-event me-2 text-primary-custom"></i>Tanggal Mulai
                                                    </label>
                                                    <input type="date" class="form-control custom-input" name="order_date" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label fw-semibold text-dark-custom">
                                                        <i class="bi bi-chat-text me-2 text-primary-custom"></i>Catatan Khusus
                                                    </label>
                                                    <textarea class="form-control custom-input" name="notes" rows="3" placeholder="Masukkan catatan khusus untuk trainer"></textarea>
                                                </div>
                                            </div>

                                            <div class="package-info mt-4">
                                                <div class="card bg-light border-0">
                                                  <div class="card-header bg-dark text-white">
    <h6 class="mb-0 fw-bold">
        <i class="bi bi-box-seam me-2 text-white"></i>Detail Paket Training
    </h6>
</div>
                                                    <div class="card-body">
                                                        <div class="row g-3">
                                                            <div class="col-6">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                                    <span>10 sesi personal training</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="bi bi-clock-fill text-primary-custom me-2"></i>
                                                                    <span>60 menit per sesi</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="bi bi-calendar-range-fill text-warning me-2"></i>
                                                                    <span>Berlaku 2 bulan</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="bi bi-currency-dollar text-success me-2"></i>
                                                                    <span class="fw-bold text-primary-custom">Rp 200.000</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">
                                            <i class="bi bi-x-circle me-2"></i>Batal
                                        </button>
                                        <button type="button" class="btn btn-primary-custom" onclick="orderTrainer({{ $trainer->id }})">
                                            <i class="bi bi-credit-card me-2"></i>Lanjut ke Pembayaran
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab 2: Pesanan Saya -->
        <div class="tab-pane fade" id="my-orders" role="tabpanel">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="d-flex align-items-center mb-4">
                        <i class="bi bi-list-columns-reverse text-primary-custom me-3 fs-2"></i>
                        <h2 class="mb-0 fw-bold text-dark-custom">Daftar Pesanan Trainer Saya</h2>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    @if($orders->count() > 0)
                        <div class="row g-4">
                            @foreach($orders as $order)
                            <div class="col-lg-6">
                                <div class="card order-card h-100">
                                  <div class="card-header bg-dark text-white d-flex align-items-center">
    <i class="bi bi-person-badge me-2"></i>
    <h5 class="mb-0 fw-bold">{{ $order->trainer->name }}</h5>
</div>
                                    <div class="card-body">
                                        <div class="order-details">
                                            <div class="detail-item mb-3">
                                                <i class="bi bi-calendar-event text-primary-custom me-2"></i>
                                                <span class="fw-semibold">Tanggal Mulai:</span>
                                                <span class="ms-2">{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</span>
                                            </div>

                                            <div class="detail-item mb-3">
                                                <i class="bi bi-credit-card text-primary-custom me-2"></i>
                                                <span class="fw-semibold">Status Pembayaran:</span>
                                                <span class="badge ms-2 {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-danger' }}">
                                                    <i class="bi bi-{{ $order->payment_status === 'paid' ? 'check-circle' : 'x-circle' }} me-1"></i>
                                                    {{ $order->payment_status === 'paid' ? 'Lunas' : 'Belum Lunas' }}
                                                </span>
                                            </div>

                                            <div class="detail-item mb-3">
                                                <i class="bi bi-info-circle text-primary-custom me-2"></i>
                                                <span class="fw-semibold">Status:</span>
                                                <span class="badge ms-2 {{ $order->status === 'active' ? 'bg-success' : ($order->status === 'cancelled' ? 'bg-danger' : 'bg-warning') }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </div>

                                            @if($order->notes)
                                                <div class="detail-item">
                                                    <i class="bi bi-chat-text text-primary-custom me-2"></i>
                                                    <span class="fw-semibold">Catatan:</span>
                                                    <p class="mt-2 p-3 bg-light rounded small">{{ $order->notes }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox display-1 text-muted mb-3"></i>
                            <h4 class="text-muted">Belum ada pesanan</h4>
                            <p class="text-muted">Pilih trainer untuk memulai perjalanan fitness Anda</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@push('scripts')

<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    document.querySelectorAll('input[type="date"]').forEach(input => {
        input.min = today;
    });

    if (window.location.hash === '#my-orders') {
        const triggerEl = document.querySelector('#orders-tab');
        if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show();
        }
    }

    const savedTab = localStorage.getItem('activeTab');
    if (savedTab === '#my-orders') {
        const triggerEl = document.querySelector('#orders-tab');
        if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show();
        }
        localStorage.removeItem('activeTab');
    }
});

function orderTrainer(trainerId) {
    const form = document.getElementById(`trainerForm-${trainerId}`);
    const button = event.target;
    const formData = new FormData(form);

    button.disabled = true;
    button.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';

    // 1. Buat order personal trainer dulu
    fetch("{{ route('user.trainer-orders.store') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            trainer_id: formData.get('trainer_id'),
            order_date: formData.get('order_date'),
            notes: formData.get('notes')
        })
    })
    .then(async response => {
        const contentType = response.headers.get("content-type");
        if (!response.ok) {
            const text = await response.text();
            throw new Error(text);
        }
        if (contentType && contentType.indexOf("application/json") !== -1) {
            return response.json();
        } else {
            const text = await response.text();
            throw new Error(text);
        }
    })
    .then(orderRes => {
        if (!orderRes.success || !orderRes.order) throw new Error('Gagal membuat order trainer');
        // 2. Setelah order berhasil, lakukan pembayaran
        return fetch("{{ route('payment.create') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                type: "personal_trainer",
                reference_id: orderRes.order.id, // gunakan id order yang baru dibuat
                amount: 200000,
                trainer_id: formData.get('trainer_id'),
                session_date: formData.get('order_date'),
                notes: formData.get('notes')
            })
        });
    })
    .then(async response => {
        const contentType = response.headers.get("content-type");
        if (!response.ok) {
            const text = await response.text();
            throw new Error(text);
        }
        if (contentType && contentType.indexOf("application/json") !== -1) {
            return response.json();
        } else {
            const text = await response.text();
            throw new Error(text);
        }
    })
    .then(data => {
        if (data.success && data.snapToken) {
            window.snap.pay(data.snapToken, {
                onSuccess: function(result) {
                    checkPaymentStatus(data.orderId);
                },
                onPending: function(result) {
                    alert('Silakan selesaikan pembayaran Anda');
                    resetButton(button);
                },
                onError: function(result) {
                    alert('Pembayaran gagal, silakan coba lagi');
                    resetButton(button);
                },
                onClose: function() {
                    resetButton(button);
                }
            });
        } else {
            throw new Error(data.message || 'Gagal memulai pembayaran');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error.message || 'Terjadi kesalahan sistem');
        resetButton(button);
    });
}

function checkPaymentStatus(orderId) {
    // Use the correct route for checking payment status
    fetch(`{{ url('/payment/check') }}/${orderId}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Payment status response:', data);

        if (data.success) {
            if (data.payment_status === 'paid') {
                alert('Pembayaran berhasil!');
                // Redirect to orders tab
                window.location.href = window.location.pathname + '?tab=my-orders';
                window.location.reload();
            } else if (data.payment_status === 'pending') {
                setTimeout(() => checkPaymentStatus(orderId), 3000);
            } else {
                alert(data.message || 'Status pembayaran: ' + data.payment_status);
                window.location.reload();
            }
        } else {
            throw new Error(data.message || 'Status pembayaran tidak valid');
        }
    })
    .catch(error => {
        console.error('Status check error:', error);
        // Don't show error alert if payment is successful
        if (!document.hidden) {
            alert('Gagal memeriksa status pembayaran: ' + error.message);
        }
    });
}

function resetButton(button) {
    button.disabled = false;
    button.innerHTML = 'Lanjut ke Pembayaran';
}


</script>
@endpush
