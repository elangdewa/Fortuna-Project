@extends('layouts.superadmin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Dashboard Super Admin</h1>

    <div class="row">
        <!-- Total Users -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Members -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active Members</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalMembers }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Coaches -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Coaches</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTrainers }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Memberships -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Active Memberships</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeMemberships }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Fitness Classes -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Fitness Classes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalFitnessClasses }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Membership Packages -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Membership Packages</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPackages }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Statistik -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Statistik Umum</h6>
        </div>
        <div class="card-body">
            <canvas id="dashboardChart"></canvas>
        </div>
    </div>
</div>

<!-- Custom CSS -->
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
.border-left-secondary {
    border-left: 4px solid #858796;
}
.border-left-dark {
    border-left: 4px solid #343a40;
}
</style>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Chart Script -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('dashboardChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Users', 'Members', 'Coaches', 'Memberships', 'Classes', 'Packages'],
            datasets: [{
                label: 'Jumlah',
                data: [
                    {{ $totalUsers }},
                    {{ $totalMembers }},
                    {{ $totalTrainers }},
                    {{ $activeMemberships }},
                    {{ $totalFitnessClasses }},
                    {{ $totalPackages }}
                ],
                backgroundColor: [
                    '#4e73df',
                    '#1cc88a',
                    '#36b9cc',
                    '#f6c23e',
                    '#858796',
                    '#343a40'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Statistik Data Dashboard'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endsection
