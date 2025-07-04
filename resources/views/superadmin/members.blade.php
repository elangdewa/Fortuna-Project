@extends('layouts.superadmin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Data Member</h1>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Status Membership</th>
                            <th>Tanggal Bergabung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->email }}</td>
                                <td>{{ $member->phone }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $member->membership && $member->membership->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $member->membership ? ucfirst($member->membership->status) : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $member->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="bi bi-inbox fs-4 text-muted mb-2"></i>
                                        <p class="text-muted mb-0">Tidak ada data member</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    .badge {
        padding: 0.5em 0.8em;
        font-weight: 500;
    }
</style>
@endpush
