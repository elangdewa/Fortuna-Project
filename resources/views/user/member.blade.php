@extends('layouts.user')

@section('user-content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold display-6 mb-3" style="color: #080808;">Pilih Paket Membership Anda!</h2>
        <p class="text-muted lead mx-auto" style="max-width: 700px;">Temukan paket yang tepat untuk mendukung perjalanan kebugaran Anda.</p>
    </div>

    @if (session('error'))
    <div class="alert border-0 shadow-sm mb-4" style="background-color: rgba(220, 53, 69, 0.1); color: #dc3545;">
        <div class="d-flex align-items-center">
            <i class="bi bi-exclamation-circle-fill me-2" style="font-size: 1.25rem;"></i>
            <div>{{ session('error') }}</div>
        </div>
    </div>
    @endif

    @if (session('success'))
    <div class="alert border-0 shadow-sm mb-4" style="background-color: rgba(25, 135, 84, 0.1); color: #198754;">
        <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2" style="font-size: 1.25rem;"></i>
            <div>{{ session('success') }}</div>
        </div>
    </div>
    @endif

    @if(isset($active_membership))
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="membership-badge me-4">
                    <i class="bi bi-award" style="font-size: 2rem; color: #da9100;"></i>
                </div>
                <div>
                    <h5 class="mb-2" style="color: #080808;">Membership Aktif</h5>
                    <p class="mb-0">
                        Anda telah memiliki membership <strong>{{ $active_membership->type->name }}</strong>
                        sejak <strong>{{ $active_membership->start_date->format('d F Y') }}</strong>
                        hingga <strong>{{ $active_membership->end_date->format('d F Y') }}</strong>
                        ({{ $active_membership->start_date->diffInDays(now()) }} hari).
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(!isset($active_membership))
    <div class="row justify-content-center g-4">
        @forelse ($types as $type)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="membership-card h-100">
                <div class="card-ribbon"></div>
                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <h5 class="card-title fw-bold" style="color: #080808;">{{ $type->name }}</h5>
                        <div class="package-duration py-1 px-3 mb-3">
                            <span>{{ $type->duration_in_months }} Bulan</span>
                        </div>
                    </div>

                    <div class="text-center mb-4">
                        <span class="price-label">Rp</span>
                        <span class="price-amount">{{ number_format($type->price, 0, ',', '.') }}</span>
                    </div>

                    <hr class="my-3">

                    <div class="benefits mb-4">
                        <div class="benefit-item">
                            <i class="bi bi-check-circle-fill me-2" style="color: #da9100;"></i>
                            <span>Akses penuh ke gym</span>
                        </div>
                        <div class="benefit-item">
                            <i class="bi bi-check-circle-fill me-2" style="color: #da9100;"></i>
                            <span>Free Wifi</span>
                        </div>
                        <div class="benefit-item">
                            <i class="bi bi-check-circle-fill me-2" style="color: #da9100;"></i>
                            <span>Isi Ulang Air</span>
                        </div>
                         <div class="benefit-item">
                            <i class="bi bi-check-circle-fill me-2" style="color: #da9100;"></i>
                            <span>Loker dan Ruang Mandi</span>
                        </div>

                        @if($type->duration_in_months >= 12)
                        <div class="benefit-item">
                            <i class="bi bi-check-circle-fill me-2" style="color: #da9100;"></i>
                            <span>Termasuk Kelas Fitness Regular</span>
                        </div>
                        @endif
                    </div>

                    <button class="btn btn-membership w-100 mt-auto py-2" data-bs-toggle="modal" data-bs-target="#modal-{{ $type->id }}">
                        Pilih Paket
                    </button>
                </div>
            </div>
        </div>

        <!-- Payment Modal -->
        <div class="modal fade" id="modal-{{ $type->id }}" tabindex="-1" aria-labelledby="modalLabel-{{ $type->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header border-0" style="background-color: #f8f9fa;">
                        <h5 class="modal-title fw-bold" id="modalLabel-{{ $type->id }}" style="color: #080808;">
                            <i class="bi bi-clipboard-check me-2" style="color: #da9100;"></i>
                            Konfirmasi Paket
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="hidden" id="userId-{{ $type->id }}" value="{{ auth()->user()->id }}">
                        <input type="hidden" id="membershipType-{{ $type->id }}" value="{{ $type->id }}">
<input type="hidden" id="price-{{ $type->id }}" value="{{ $type->price }}">

                        <div class="package-summary mb-4 p-3" style="background-color: #f8f9fa; border-radius: 10px;">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Nama Paket</span>
                                <span class="fw-medium">{{ $type->name }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Durasi</span>
                                <span class="fw-medium">{{ $type->duration_in_months }} Bulan</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Harga</span>
                                <span class="fw-medium">Rp {{ number_format($type->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Tanggal Mulai</span>
                                <span class="fw-medium">{{ \Carbon\Carbon::now()->format('d F Y') }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Tanggal Berakhir</span>
                                <span class="fw-medium">{{ \Carbon\Carbon::now()->addMonths($type->duration_in_months)->format('d F Y') }}</span>
                            </div>
                        </div>

                        <div class="terms-section p-3 mb-3" style="border: 1px solid #e0e0e0; border-radius: 10px;">
                            <h6 class="mb-2" style="color: #080808;">Syarat dan Ketentuan</h6>
                            <ul class="small text-muted mb-0">
                                <li>Membership akan aktif segera setelah pembayaran berhasil</li>
                                <li>Tidak ada pengembalian dana setelah pembayaran berhasil</li>
                                <li>Membership tidak dapat dipindah tangankan</li>
                                <li>Anda wajib mematuhi peraturan gym selama menggunakan fasilitas</li>
                            </ul>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" required id="termsCheck-{{ $type->id }}">
                            <label class="form-check-label" for="termsCheck-{{ $type->id }}">
                                Saya setuju dengan syarat dan ketentuan
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-membership" onclick="startPayment({{ $type->id }})">
                            <i class="bi bi-credit-card me-2"></i>Konfirmasi & Bayar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state text-center p-5" style="background-color: #f8f9fa; border-radius: 10px;">
                <i class="bi bi-box2 mb-3" style="font-size: 3rem; color: #cacaca;"></i>
                <p class="text-muted mb-0">Tidak ada paket tersedia.</p>
            </div>
        </div>
        @endforelse
    </div>
    @endif
</div>


 @if(session('success'))
    <div id="successModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm">
            <h3 class="text-lg font-bold text-green-600 mb-4">Pembayaran Berhasil</h3>
            <p class="text-gray-700">{{ session('success') }}</p>
            <button onclick="closeModal()" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Tutup
            </button>
        </div>
    </div>
    @endif

      @if(session('error'))
        <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-4">
            {{ session('error') }}
        </div>
        @endif

<style>
:root {
    --primary-color: #da9100;
    --dark-color: #080808;
    --light-gray: #f5f5f5;
    --medium-gray: #e0e0e0;
}

/* Membership Card Styling */
.membership-card {
    position: relative;
    background: white;
    border-radius: 15px;
    border: none;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.membership-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(218, 145, 0, 0.1);
}

.card-ribbon {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 8px;
    background-color: var(--primary-color);
}

.package-duration {
    display: inline-block;
    background-color: rgba(218, 145, 0, 0.1);
    color: var(--primary-color);
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
}

.price-label {
    vertical-align: top;
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--dark-color);
    margin-right: 2px;
}

.price-amount {
    font-size: 2rem;
    font-weight: 700;
    color: var(--dark-color);
    line-height: 1;
}

.benefit-item {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
    font-size: 0.9rem;
}

.btn-membership {
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: 50px;
    padding: 10px 20px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-membership:hover {
    background-color: #c48200;
    color: white;
    box-shadow: 0 5px 15px rgba(218, 145, 0, 0.3);
}

/* Success Modal */
.success-icon-container {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 120px;
    height: 120px;
    border-radius: 60px;
    background-color: rgba(25, 135, 84, 0.1);
}

/* Form Elements */
.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

/* Active Membership Card */
.membership-badge {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background-color: rgba(218, 145, 0, 0.1);
}

/* Animation */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.btn-membership:focus {
    animation: pulse 1s infinite;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .price-amount { font-size: 1.5rem; }
    .price-label { font-size: 1rem; }
    .card-title { font-size: 1.1rem; }
    .benefit-item { font-size: 0.8rem; }
}
</style>

<script>
function startPayment(typeId) {
    if (!document.getElementById(`termsCheck-${typeId}`).checked) {
        alert('Harap setujui syarat dan ketentuan terlebih dahulu.');
        return;
    }

    const button = document.querySelector(`#modal-${typeId} .btn-membership`);
    const originalContent = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';

    const csrfToken = '{{ csrf_token() }}';

    fetch("{{ route('payment.create') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify({
            type: 'membership',
            reference_id: typeId,
            amount: parseInt(document.getElementById(`price-${typeId}`).value)
        }),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Gagal membuat transaksi. Silakan coba lagi.');
        }
        return response.json();
    })
    .then(data => {
        if (data.success && data.snapToken) {
            // Panggil Midtrans Snap untuk memulai pembayaran
            window.snap.pay(data.snapToken, {
                onSuccess: function(result) {
                    alert('Pembayaran berhasil!');
                    window.location.href = "{{ route('payment.status', ':orderId') }}".replace(':orderId', result.order_id);
                },
                onPending: function(result) {
                    alert('Pembayaran belum selesai. Silakan selesaikan pembayaran.');
                },
                onError: function(result) {
                    console.error('Payment Error:', result);
                    alert('Terjadi kesalahan saat pembayaran.');
                },
                onClose: function() {
                    alert('Anda menutup pembayaran tanpa menyelesaikannya.');
                }
            });
        } else {
            alert(data.error || 'Gagal mendapatkan token pembayaran.');
        }
    })
    .catch(error => {
        console.error('Payment Error:', error);
        alert('Terjadi kesalahan dalam proses pembayaran.');
    })
    .finally(() => {
        button.disabled = false;
        button.innerHTML = originalContent;
    });
}
</script>


<!-- Midtrans SDK -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

@endsection
