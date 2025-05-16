@extends('layouts.admin')

@section('admin-content')
<div class="container-fluid py-4">
    <h1 class="h3 mb-4">Dashboard</h1>

    <div class="row">
        <!-- Members Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Member</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalMembers ?? '0' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trainers Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Coach</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTrainers ?? '0' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-person-badge fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fitness Classes Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Kelas Fitness</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalFitnessClasses ?? '0' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-bicycle fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Membership Packages Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Paket Member</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPackages ?? '0' }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-box-seam fs-2 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Members Table -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Member Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Paket</th>
                                    <th>Tanggal Bergabung</th>
                                </tr>
                            </thead>
                            <tbody>
                              @forelse($recentMembers as $member)
<tr>
    <td>{{ $member->name ?? 'N/A' }}</td>
    <td>{{ $member->email ?? 'N/A' }}</td>
    <td>{{ optional($member->membershipType)->name ?? 'Belum ada paket' }}</td>
    <td>{{ optional($member->created_at)->format('d M Y') ?? 'N/A' }}</td>
</tr>
@empty
<tr>
    <td colspan="4" class="text-center">Tidak ada data member</td>
</tr>
@endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 4px solid #4e73df;
}
.border-left-success {
    border-left: 4px solid #1cc88a;
}
.border-left-info {
    border-left: 4px solid #36b9cc;
}
.border-left-warning {
    border-left: 4px solid #f6c23e;
}
</style>
@endsection
