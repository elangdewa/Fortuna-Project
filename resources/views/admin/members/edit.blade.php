@extends('layouts.admin')

@section('admin-content')
<link href="{{ asset('css/create.css') }}" rel="stylesheet">


<!-- Tambahkan kelas main-content untuk memastikan ada jarak dari sidebar -->
<div class="main-content container mt-5">

    <h2>Edit Member</h2>

    <form action="{{ route('admin.members.update', $member->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $member->name) }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $member->email) }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="phone">Telepon</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $member->phone) }}" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select name="gender" class="form-control" required>
                    <option value="">-- Pilih Gender --</option>
                    <option value="Laki-laki" {{ $member->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ $member->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="address">Alamat</label>
                <input name="address" class="form-control" value="{{ old('address', $member->address) }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="membership_type_id">Tipe Membership:</label>
                <select id="membership_type_id" name="membership_type_id" class="form-control" onchange="getMembershipData(this.value)" required>
                    <option value="">-- Pilih Membership --</option>
                    @foreach($memberships as $membership)
                        <option value="{{ $membership->id }}" 
                                data-price="{{ $membership->price }}"
                                data-duration="{{ $membership->duration_in_months }}"
                                {{ $member->membership->membership_type == $membership->id ? 'selected' : '' }}>
                                {{ $membership->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="price_display">Harga:</label>
                <input type="text" id="price_display" class="form-control" readonly>
                <input type="hidden" id="price" name="price" value="{{ $member->membership->price ?? 0 }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Tanggal Mulai:</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ old('start_date', $member->membership->start_date ? date('Y-m-d', strtotime($member->membership->start_date)) : '') }}" required>
            </div>

            <div class="form-group">
                <label>Tanggal Berakhir:</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ old('end_date', $member->membership->end_date ? date('Y-m-d', strtotime($member->membership->end_date)) : '') }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ $member->membership->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="expired" {{ $member->membership->status == 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="inactive" {{ $member->membership->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="form-group">
                <label for="payment_status">Payment Status:</label>
                <select name="payment_status" class="form-control" required>
                    <option value="paid" {{ $member->membership->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="unpaid" {{ $member->membership->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
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
        
        // Set the price fields
        document.getElementById('price_display').value = formatRupiah(selectedMembership.price);
        document.getElementById('price').value = selectedMembership.price;
        
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
            // If start date is already set, just recalculate the end date if user wants to
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
        return 'Rp' + Number(amount).toLocaleString('id-ID');
    }
</script>
@endpush