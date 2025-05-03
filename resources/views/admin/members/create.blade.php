@extends('layouts.admin')

@section('admin-content')

<link href="{{ asset('css/create.css') }}" rel="stylesheet">

<div class="main-content">
    <div class="container">
        <div class="card p-4">
            <h2>Tambah Member Baru</h2>
            <hr>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.members.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>No Telepon</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Gender</label>
                        <select name="gender" class="form-control" required>
                            <option value="">-- Pilih Gender --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Alamat</label>
                        <input name="address" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="membership_type_id">Tipe Membership:</label>
                        <select id="membership_type_id" name="membership_type_id" class="form-control" onchange="getMembershipData(this.value)" required>
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

                    <div class="col-md-6 mb-3">
                        <label for="price_display">Harga:</label>
                        <input type="text" id="price_display" class="form-control" readonly>
                        <input type="hidden" id="price" name="price">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Tanggal Mulai:</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Tanggal Berakhir:</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" readonly>
                    </div>

                    <div class="col-md-12 text-end mt-4">
                        <button type="submit" class="btn btn-warning px-4 py-2">
                            <i class="fas fa-plus me-2"></i>Tambah Member
                        </button>
                    </div>
                </div>
            </form>
        </div>
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
    }

    function resetFormFields() {
        document.getElementById('price_display').value = '';
        document.getElementById('price').value = '';
        document.getElementById('start_date').value = '';
        document.getElementById('end_date').value = '';
    }

    function formatRupiah(amount) {
        return 'Rp' + Number(amount).toLocaleString('id-ID');
    }
</script>
@endpush
