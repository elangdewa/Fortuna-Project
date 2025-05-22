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

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-5">
                <div class="success-icon-container mb-4">
                    <i class="bi bi-check-circle-fill" style="font-size: 4rem; color: #198754;"></i>
                </div>
                <h3 class="mb-3 fw-bold" style="color: #080808;">Pembayaran Berhasil!</h3>
                <p class="lead mb-4">Membership Anda telah diaktifkan.</p>
                <button type="button" class="btn btn-lg btn-membership px-5" data-bs-dismiss="modal" onclick="window.location.reload()">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

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
    // Check terms agreement
    if (!document.getElementById(`termsCheck-${typeId}`).checked) {
        showToast('Harap setujui syarat dan ketentuan terlebih dahulu.', 'warning');
        return;
    }

    // Disable button and show loading
    const button = document.querySelector(`#modal-${typeId} .btn-membership`);
    const originalContent = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';

    const csrfToken = '{{ csrf_token() }}';
    fetch("{{ route('payments.membership') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify({
            membership_type: typeId
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.snap_token) {
            window.snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    // Kirim request untuk memverifikasi pembayaran
                    fetch("{{ route('payments.verify') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        body: JSON.stringify({
                            order_id: result.order_id
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Hide the current modal
                            bootstrap.Modal.getInstance(document.getElementById(`modal-${typeId}`)).hide();

                            // Show success modal
                            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                            successModal.show();

                            // Reload after 3 seconds
                            setTimeout(() => window.location.reload(), 3000);
                        } else {
                            showToast("Pembayaran berhasil tetapi terjadi kesalahan sistem. Tim kami akan memverifikasi pembayaran Anda.", "warning");
                        }
                    });
                },
                onPending: function(result) {
                    showToast("Transaksi belum selesai. Silakan selesaikan pembayaran.", "info");
                },
                onError: function(result) {
                    console.error('Payment Error:', result);
                    showToast("Terjadi kesalahan saat pembayaran.", "error");
                },
                onClose: function() {
                    showToast("Kamu menutup pembayaran tanpa menyelesaikannya.", "warning");
                }
            });
        } else {
            showToast(data.error || "Gagal mendapatkan token pembayaran.", "error");
        }
    })
    .catch(error => {
        console.error("Payment Error:", error);
        showToast("Terjadi kesalahan dalam proses pembayaran.", "error");
    })
    .finally(() => {
        // Re-enable button
        button.disabled = false;
        button.innerHTML = originalContent;
    });
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
    toast.className = `toast align-items-center border-0`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');

    // Set background color based on type
    let iconClass = 'bi-info-circle-fill';
    switch (type) {
        case 'success':
            toast.style.backgroundColor = '#198754';
            toast.className += ' text-white';
            iconClass = 'bi-check-circle-fill';
            break;
        case 'error':
            toast.style.backgroundColor = '#dc3545';
            toast.className += ' text-white';
            iconClass = 'bi-exclamation-circle-fill';
            break;
        case 'warning':
            toast.style.backgroundColor = '#ffc107';
            toast.className += ' text-dark';
            iconClass = 'bi-exclamation-triangle-fill';
            break;
        default:
            toast.style.backgroundColor = '#0d6efd';
            toast.className += ' text-white';
    }


    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi ${iconClass} me-2"></i>${message}
            </div>
            <button type="button" class="btn-close ${type !== 'warning' ? 'btn-close-white' : ''} me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;


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

<!-- Midtrans SDK -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

@endsection
