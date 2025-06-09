@extends('layouts.admin')

@section('admin-content')

<link href="{{ asset('css/create.css') }}" rel="stylesheet">

<div class="main-content">
    <div class="form-container">
        <div class="form-header">
            <div class="header-icon">
                <i class="fas fa-user-edit"></i>
            </div>
            <h2>Edit Member</h2>
            <p class="form-subtitle">Perbarui informasi member dan pengaturan membership</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.members.update', $member->id) }}" method="POST" class="modern-form">
            @csrf
            @method('PUT')

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
                            <input type="text" name="name" class="form-control" value="{{ old('name', $member->name) }}" placeholder="Masukkan nama lengkap" required>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $member->email) }}" placeholder="example@email.com" required>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-phone me-2"></i>No Telepon
                            </label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $member->phone) }}" placeholder="08xxxxxxxxxx" required>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-venus-mars me-2"></i>Gender
                            </label>
                            <select name="gender" class="form-control custom-select" required>
                                <option value="">-- Pilih Gender --</option>
                                <option value="Laki-laki" {{ old('gender', $member->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('gender', $member->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 mb-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-map-marker-alt me-2"></i>Alamat
                            </label>
                            <textarea name="address" class="form-control" rows="3" placeholder="Masukkan alamat lengkap" required>{{ old('address', $member->address) }}</textarea>
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
                            <select id="membership_type_id" name="membership_type_id" class="form-control custom-select" onchange="getMembershipData(this.value)" required>
                                <option value="">-- Pilih Membership --</option>
                                @foreach($memberships as $membership)
                                    <option value="{{ $membership->id }}"
                                            data-price="{{ $membership->price }}"
                                            data-duration="{{ $membership->duration_in_months }}"
                                            {{ old('membership_type_id', $member->membership->membership_type ?? '') == $membership->id ? 'selected' : '' }}>
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
                            <input type="hidden" id="price" name="price" value="{{ old('price', $member->membership->price ?? 0) }}">
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-calendar-plus me-2"></i>Tanggal Mulai
                            </label>
                            <input type="date" id="start_date" name="start_date" class="form-control"
                                   value="{{ old('start_date', $member->membership->start_date ? date('Y-m-d', strtotime($member->membership->start_date)) : '') }}" required>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-calendar-times me-2"></i>Tanggal Berakhir
                            </label>
                            <input type="date" id="end_date" name="end_date" class="form-control"
                                   value="{{ old('end_date', $member->membership->end_date ? date('Y-m-d', strtotime($member->membership->end_date)) : '') }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Information Section -->
            <div class="form-section">
                <div class="section-header">
                    <i class="fas fa-toggle-on"></i>
                    <span>Status & Pembayaran</span>
                </div>

                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user-check me-2"></i>Status Member
                            </label>
                            <select name="status" class="form-control custom-select status-select" required>
                                <option value="active" {{ old('status', $member->membership->status ?? '') == 'active' ? 'selected' : '' }}>
                                    <span class="status-active">Active</span>
                                </option>
                                <option value="expired" {{ old('status', $member->membership->status ?? '') == 'expired' ? 'selected' : '' }}>
                                    <span class="status-expired">Expired</span>
                                </option>
                                <option value="inactive" {{ old('status', $member->membership->status ?? '') == 'inactive' ? 'selected' : '' }}>
                                    <span class="status-inactive">Inactive</span>
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-credit-card me-2"></i>Status Pembayaran
                            </label>
                            <select name="payment_status" class="form-control custom-select payment-select" required>
                                <option value="paid" {{ old('payment_status', $member->membership->payment_status ?? '') == 'paid' ? 'selected' : '' }}>
                                    <span class="payment-paid">Paid</span>
                                </option>
                                <option value="unpaid" {{ old('payment_status', $member->membership->payment_status ?? '') == 'unpaid' ? 'selected' : '' }}>
                                    <span class="payment-unpaid">Unpaid</span>
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Actions -->
            <div class="form-actions">
                <a href="{{ route('members.view') }}" class="btn btn-secondary me-3">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Member
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Define memberships array directly with the necessary data from PHP
    const memberships = [
        @foreach($memberships as $membership)
        {
            id: {{ $membership->id }},
            price: {{ $membership->price }},
            duration_in_months: {{ $membership->duration_in_months }}
        }{{ !$loop->last ? ',' : '' }}
        @endforeach
    ];

    // Run this on page load to set the initial price display
    document.addEventListener('DOMContentLoaded', function() {
        const selectedMembershipId = document.getElementById('membership_type_id').value;
        if (selectedMembershipId) {
            getMembershipData(selectedMembershipId);
        }

        // Add form validation feedback
        const form = document.querySelector('.modern-form');
        const inputs = form.querySelectorAll('input, select, textarea');

        inputs.forEach(input => {
            // Set initial has-value class for fields with values
            if (input.value.trim() !== '') {
                input.classList.add('has-value');
            }

            input.addEventListener('blur', function() {
                if (this.value.trim() !== '') {
                    this.classList.add('has-value');
                } else {
                    this.classList.remove('has-value');
                }
            });
        });

        // Add status color indicators
        updateStatusColors();
    });

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

        // Set the price fields with animation
        const priceField = document.getElementById('price_display');
        priceField.value = formatRupiah(selectedMembership.price);
        document.getElementById('price').value = selectedMembership.price;

        // Add animation effect
        priceField.style.animation = 'fadeInPrice 0.5s ease-in-out';

        // For edit form, we might want to set the dates differently
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        // If no dates are set yet, we can set default values
        if (!startDateInput.value) {
            const today = new Date();
            startDateInput.value = today.toISOString().split('T')[0];

            // Calculate end date based on membership duration
            const endDate = new Date(today);
            endDate.setMonth(endDate.getMonth() + parseInt(selectedMembership.duration_in_months));
            endDateInput.value = endDate.toISOString().split('T')[0];
        } else {
            // If start date is already set, ask user if they want to update end date
            if (confirm('Apakah Anda ingin memperbarui tanggal berakhir berdasarkan durasi membership yang baru?')) {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(startDate);
                endDate.setMonth(endDate.getMonth() + parseInt(selectedMembership.duration_in_months));
                endDateInput.value = endDate.toISOString().split('T')[0];
            }
        }
    }

    function resetFormFields() {
        document.getElementById('price_display').value = '';
        document.getElementById('price').value = '';
        // In edit form, we might not want to reset date fields
    }

    function formatRupiah(amount) {
        return 'Rp ' + Number(amount).toLocaleString('id-ID');
    }

    function updateStatusColors() {
        const statusSelect = document.querySelector('select[name="status"]');
        const paymentSelect = document.querySelector('select[name="payment_status"]');

        if (statusSelect) {
            statusSelect.addEventListener('change', function() {
                this.className = `form-control custom-select status-${this.value}`;
            });
            // Set initial class
            statusSelect.className = `form-control custom-select status-${statusSelect.value}`;
        }

        if (paymentSelect) {
            paymentSelect.addEventListener('change', function() {
                this.className = `form-control custom-select payment-${this.value}`;
            });
            // Set initial class
            paymentSelect.className = `form-control custom-select payment-${paymentSelect.value}`;
        }
    }
</script>
@endpush
