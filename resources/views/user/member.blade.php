<link rel="stylesheet" href="{{ asset('css/alluser.css') }}">
@extends('layouts.user')

@section('user-content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold display-6 mb-3" style="color: #080808;">Pilih Paket Membership Anda!</h2>
        <p class="text-muted lead mx-auto" style="max-width: 700px;">Temukan paket yang tepat untuk mendukung perjalanan kebugaran Anda.</p>
    </div>
<div class="d-flex justify-content-center mb-4">
    <div class="status-toggle-section">
        <button class="status-toggle-btn active" id="statusBtn">
            <i class="bi bi-person-badge me-2"></i>Status Membership
        </button>
        <button class="status-toggle-btn" id="riwayatBtn">
            <i class="bi bi-clock-history me-2"></i>Riwayat Membership
        </button>
    </div>
</div>
<div id="statusSection" style="display: block;">
    @if(($active_membership ?? $latest_membership) && ($active_membership ?? $latest_membership)->type)
        <div class="membership-status-card">
            <div class="membership-status-header">
                <div class="status-icon">
                    <i class="bi bi-person-check-fill" style="font-size: 1.5rem; color: var(--primary-color);"></i>
                </div>
                <h5 class="text-center fw-bold mb-0" style="color: var(--dark-color);">
                    Informasi Membership Aktif
                </h5>
            </div>
            <div class="membership-status-body">
                <div class="membership-info-item">
                    <span class="info-label">
                        <i class="bi bi-person me-2"></i>Nama Lengkap
                    </span>
                    <span class="info-value">{{ $user->name }}</span>
                </div>

                <div class="membership-info-item">
                    <span class="info-label">
                        <i class="bi bi-telephone me-2"></i>Nomor Telepon
                    </span>
                    <span class="info-value">{{ $user->phone ?? 'Belum diatur' }}</span>
                </div>

                <div class="membership-info-item">
                    <span class="info-label">
                        <i class="bi bi-check-circle me-2"></i>Status
                    </span>
                    <span class="info-value">
                        <span class="status-badge status-{{ strtolower(($active_membership ?? $latest_membership)->status) }}">
                            {{ ucfirst(($active_membership ?? $latest_membership)->status) }}
                        </span>
                    </span>
                </div>

                <div class="membership-info-item">
                    <span class="info-label">
                        <i class="bi bi-award me-2"></i>Jenis Membership
                    </span>
                    <span class="info-value membership-type-cell">
                        {{ ($active_membership ?? $latest_membership)->type->name }}
                    </span>
                </div>

                <div class="membership-info-item">
                    <span class="info-label">
                        <i class="bi bi-calendar-check me-2"></i>Tanggal Mulai
                    </span>
                    <span class="info-value date-cell">
                        {{ \Carbon\Carbon::parse(($active_membership ?? $latest_membership)->start_date)->format('d M Y') }}
                    </span>
                </div>

                <div class="membership-info-item">
                    <span class="info-label">
                        <i class="bi bi-calendar-x me-2"></i>Tanggal Berakhir
                    </span>
                    <span class="info-value date-cell">
                        {{ \Carbon\Carbon::parse(($active_membership ?? $latest_membership)->end_date)->format('d M Y') }}
                    </span>
                </div>
            </div>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="bi bi-person-x" style="font-size: 2rem; color: var(--primary-color);"></i>
            </div>
            <h5 class="empty-state-title">Belum Ada Membership</h5>
            <p class="empty-state-text">
                Anda belum memiliki membership yang terdaftar. Silakan pilih paket membership di bawah untuk memulai.
            </p>
        </div>
    @endif
</div>

<!-- History Section -->
<div id="riwayatSection" style="display: none;">
    @if(isset($membership_history) && count($membership_history))
        <div class="history-section">
            <div class="history-header">
                <h4 class="mb-0 fw-bold d-flex align-items-center" style="color: var(--dark-color);">
                    <i class="bi bi-clock-history me-3" style="color: var(--primary-color);"></i>
                    Riwayat Membership
                </h4>
                <p class="text-muted mb-0 mt-2">Berikut adalah riwayat semua membership yang pernah Anda miliki</p>
            </div>
            <div class="history-table-wrapper">
                <table class="history-table table">
                    <thead>
                        <tr>
                            <th>
                                <i class="bi bi-award me-2"></i>Jenis Membership
                            </th>
                            <th>
                                <i class="bi bi-calendar-event me-2"></i>Tanggal Mulai
                            </th>
                            <th>
                                <i class="bi bi-calendar-check me-2"></i>Tanggal Berakhir
                            </th>
                            <th>
                                <i class="bi bi-check-circle me-2"></i>Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($membership_history as $membership)
                        <tr>
                            <td class="membership-type-cell">
                                <strong>{{ $membership->type->name }}</strong>
                            </td>
                            <td class="date-cell">
                                {{ \Carbon\Carbon::parse($membership->start_date)->format('d M Y') }}
                            </td>
                            <td class="date-cell">
                                {{ \Carbon\Carbon::parse($membership->end_date)->format('d M Y') }}
                            </td>
                            <td>
                                <span class="status-badge status-{{ strtolower($membership->status) }}">
                                    {{ ucfirst($membership->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="bi bi-clock-history" style="font-size: 2rem; color: var(--primary-color);"></i>
            </div>
            <h5 class="empty-state-title">Belum Ada Riwayat</h5>
            <p class="empty-state-text">
                Anda belum memiliki riwayat membership. Riwayat akan muncul setelah Anda memiliki membership.
            </p>
        </div>
    @endif
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

                    <button class="btn-membership w-100 mt-auto py-2" data-bs-toggle="modal" data-bs-target="#modal-{{ $type->id }}">
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

<div class="modal fade" id="paymentStatusModal" tabindex="-1" aria-labelledby="paymentStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentStatusModalLabel">Status Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="paymentStatusMessage">Pembayaran Anda sedang diproses...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

 <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-body text-center p-5">
                    <div class="success-icon mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="mb-3">Pembayaran Berhasil!</h3>
                    <p class="mb-4 text-muted">Anda telah berhasil mendaftar memberships.</p>
                    <button type="button" class="btn btn-lg px-5 btn-booking" onclick="window.location.reload()">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


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

document.getElementById('statusBtn').addEventListener('click', function () {
    document.getElementById('statusSection').style.display = 'block';
    document.getElementById('riwayatSection').style.display = 'none';
});

document.getElementById('riwayatBtn').addEventListener('click', function () {
    document.getElementById('statusSection').style.display = 'none';
    document.getElementById('riwayatSection').style.display = 'block';
});

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


<!-- Midtrans SDK -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

@endsection
