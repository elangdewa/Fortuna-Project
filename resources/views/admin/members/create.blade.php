@extends('layouts.admin')

@section('admin-content')

<link href="{{ asset('css/create.css') }}" rel="stylesheet">

<div class="main-content">
    <div class="form-container">
        <div class="form-header">
            <h2>Tambah Member Baru</h2>
            <p class="form-subtitle">Lengkapi informasi member untuk mendaftar membership</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.members.store') }}" method="POST" class="modern-form">
            @csrf

            <!-- Personal Information Section -->
            <div class="form-section">
                <div class="section-header">
                    <i class="fas fa-user"></i>
                    <span>Informasi Personal</span>
                </div>

                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user me-2"></i>Nama Lengkap
                            </label>
                            <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" required>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <input type="email" name="email" class="form-control" placeholder="example@email.com" required>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-phone me-2"></i>No Telepon
                            </label>
                            <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx" required>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-venus-mars me-2"></i>Gender
                            </label>
                            <select name="gender" class="form-control custom-select" required>
                                <option value="">-- Pilih Gender --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 mb-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-map-marker-alt me-2"></i>Alamat
                            </label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Membership Information Section -->
            <div class="form-section">
                <div class="section-header">
                    <i class="fas fa-crown"></i>
                    <span>Informasi Membership</span>
                </div>

                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-star me-2"></i>Tipe Membership
                            </label>
                            <select id="membership_type" name="membership_type" class="form-control custom-select" onchange="getMembershipData(this.value)" required>
                                <option value="">-- Pilih Membership --</option>
                                @foreach($memberships as $membership)
                                    <option value="{{ $membership->id }}"
                                            data-price="{{ $membership->price }}"
                                            data-duration="{{ $membership->duration_in_months }}">
                                        {{ $membership->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-money-bill me-2"></i>Harga
                            </label>
                            <input type="text" id="price_display" class="form-control price-display" placeholder="Pilih membership terlebih dahulu" readonly>
                            <input type="hidden" id="price" name="price">
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-calendar-plus me-2"></i>Tanggal Mulai
                            </label>
                            <input type="date" id="start_date" name="start_date" class="form-control" required readonly>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-calendar-times me-2"></i>Tanggal Berakhir
                            </label>
                            <input type="date" id="end_date" name="end_date" class="form-control" required readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-actions">
                <button type="button" class="btn btn-secondary me-3" onclick="window.history.back();">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan Member
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const memberships = JSON.parse('{!! $memberships_json !!}');

    function getMembershipData(membershipId) {
        if (!membershipId) {
            resetFormFields();
            return;
        }

        const selectedMembership = memberships.find(m => m.id == membershipId);

        if (!selectedMembership) {
            console.error('Membership tidak ditemukan');
            resetFormFields();
            return;
        }

        const today = new Date();
        const startDate = today.toISOString().split('T')[0];

        const endDate = new Date(today);
        endDate.setMonth(endDate.getMonth() + parseInt(selectedMembership.duration));
        const endDateFormatted = endDate.toISOString().split('T')[0];

        document.getElementById('price_display').value = formatRupiah(selectedMembership.price);
        document.getElementById('price').value = selectedMembership.price;
        document.getElementById('start_date').value = startDate;
        document.getElementById('end_date').value = endDateFormatted;

        // Add animation effect
        const priceField = document.getElementById('price_display');
        priceField.style.animation = 'fadeInPrice 0.5s ease-in-out';
    }

    function resetFormFields() {
        document.getElementById('price_display').value = '';
        document.getElementById('price').value = '';
        document.getElementById('start_date').value = '';
        document.getElementById('end_date').value = '';
    }

    function formatRupiah(amount) {
        return 'Rp ' + Number(amount).toLocaleString('id-ID');
    }

    // Add form validation feedback
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.modern-form');
        const inputs = form.querySelectorAll('input, select, textarea');

        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() !== '') {
                    this.classList.add('has-value');
                } else {
                    this.classList.remove('has-value');
                }
            });
        });
    });
</script>
@endpush
