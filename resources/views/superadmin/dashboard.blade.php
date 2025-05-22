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
@endsection
