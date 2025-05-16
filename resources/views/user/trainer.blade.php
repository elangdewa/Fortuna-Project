@extends('layouts.user')

@section('user-content')
<div class="container mt-5">
    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" id="trainerTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="choose-tab" data-bs-toggle="tab" data-bs-target="#choose-trainer" type="button" role="tab">
                Pilih Trainer
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#my-orders" type="button" role="tab">
                Pesanan Saya
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="trainerTabsContent">
        <!-- Tab 1: Pilih Trainer -->
        <div class="tab-pane fade show active" id="choose-trainer" role="tabpanel">
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
                                    <h5 class="card-subtitle mb-2">Spesialisasi</h5>
                                </div>
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderModal-{{ $trainer->id }}">
                                    Pilih Trainer
                                </button>
                            </div>
                            <p class="trainer-experience">Pengalaman: {{ $trainer->experience }}</p>
                        </div>
                    </div>
                </div>

                <!-- Modal untuk setiap trainer -->
                <div class="modal fade" id="orderModal-{{ $trainer->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pesan Trainer {{ $trainer->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="trainerForm-{{ $trainer->id }}">
                                    @csrf
                                    <input type="hidden" name="trainer_id" value="{{ $trainer->id }}">

                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Mulai</label>
                                        <input type="date" class="form-control" name="order_date" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Catatan Khusus</label>
                                        <textarea class="form-control" name="notes" rows="3" placeholder="Masukkan catatan khusus untuk trainer"></textarea>
                                    </div>

                                    <div class="alert alert-info">
                                        <p class="mb-0"><strong>Detail Paket:</strong></p>
                                        <ul class="mb-0">
                                            <li>10 sesi personal training</li>
                                            <li>Durasi: 60 menit per sesi</li>
                                            <li>Berlaku 2 bulan</li>
                                            <li>Total: Rp 200.000</li>
                                        </ul>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-primary" onclick="orderTrainer({{ $trainer->id }})">
                                    Lanjut ke Pembayaran
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Tab 2: Daftar Pesanan -->
        <div class="tab-pane fade" id="my-orders" role="tabpanel">
            <h2 class="mb-4">Daftar Pesanan Trainer Saya</h2>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="list-group">
                @foreach($orders as $order)
                <div class="list-group-item mb-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>{{ $order->trainer->name }}</h5>
                            <p class="mb-1">Tanggal Mulai: {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</p>
                            <p class="mb-1">Status Pembayaran:
                                <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                    {{ $order->payment_status === 'paid' ? 'Lunas' : 'Belum Lunas' }}
                                </span>
                            </p>
                            <p class="mb-1">Status:
                                <span class="badge bg-{{ $order->status === 'active' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                            @if($order->notes)
                                <p class="mb-0">Catatan: {{ $order->notes }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
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
    if (typeof window.snap === 'undefined') {
        console.error('Midtrans Snap belum dimuat');
        alert('Sistem pembayaran belum siap. Mohon muat ulang halaman.');
        return;
    }

    const form = document.getElementById(`trainerForm-${trainerId}`);
    const button = event.target;

    button.disabled = true;
    button.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';

    const formData = new FormData(form);
    const data = {
        trainer_id: formData.get('trainer_id'),
        order_date: formData.get('order_date'),
        notes: formData.get('notes'),
        sessions: 10,
        price: 200000
    };

    fetch("{{ route('payments.trainer') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json",
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success && data.snap_token) {
            window.snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    localStorage.setItem('activeTab', '#my-orders');
                    window.location.reload();
                },
                onPending: function(result) {
                    alert('Silakan selesaikan pembayaran Anda');
                    button.disabled = false;
                    button.innerHTML = 'Lanjut ke Pembayaran';
                },
                onError: function(result) {
                    console.error('Payment error:', result);
                    alert('Pembayaran gagal, silakan coba lagi');
                    button.disabled = false;
                    button.innerHTML = 'Lanjut ke Pembayaran';
                },
                onClose: function() {
                    button.disabled = false;
                    button.innerHTML = 'Lanjut ke Pembayaran';
                }
            });
        } else {
            throw new Error(data.message || 'Terjadi kesalahan sistem');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error.message || 'Terjadi kesalahan sistem');
        button.disabled = false;
        button.innerHTML = 'Lanjut ke Pembayaran';
    });
}
</script>
@endpush

@push('styles')
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
    color: #080808;
}

.btn-outline-primary {
    border-radius: 20px;
    padding: 8px 20px;
}

.trainer-card .card-body .trainer-experience {
    color: #000 !important;
    font-weight: 600;
    margin-top: 10px;
    font-size: 1rem;
}

.modal-content {
    border-radius: 15px;
}

.nav-tabs {
    border-bottom: 2px solid #dee2e6;
    margin-bottom: 2rem;
}

.nav-tabs .nav-link {
    border: none;
    color: #6c757d;
    font-weight: 500;
    padding: 15px 30px; /* Increase padding */
    font-size: 1.1rem; /* Larger font */
    transition: all 0.3s ease;
}

.nav-tabs .nav-item {
    margin-bottom: -2px;
    min-width: 200px; /* Make tabs wider */
    text-align: center;
}

.nav-tabs .nav-link:hover {
    color: #da9100;
    border-bottom: 3px solid rgba(218, 145, 0, 0.5);
}


.nav-tabs .nav-link.active {
    color: #da9100;
    border-bottom: 3px solid #da9100;
    background-color: transparent;
    font-weight: 600;
}

.list-group-item {
    border-radius: 10px !important;
    margin-bottom: 10px;
    border: 1px solid rgba(0,0,0,.125);
}

.spinner-border {
    width: 1rem;
    height: 1rem;
    border-width: 0.2em;
}
</style>
@endpush
