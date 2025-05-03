@extends('layouts.app')

@section('content')
@include('layouts.sidenavbar')

{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <p>{{ __('Welcome, Admin!') }}</p>
                    <p>You are logged in as <strong>admin</strong>.</p> 

                   
                   <ul>
                        <li><a href="#">Manage Users</a></li>
                        <li><a href="#">Manage Classes</a></li>
                        <li><a href="#">View Reports</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
       
        <div class="col-md-2 sidebar d-flex flex-column align-items-center">
            <div class="text-center mb-4">
                <img src="https://via.placeholder.com/80" class="rounded-circle mb-2" alt="Admin">
                <h5>Admin</h5>
            </div>

            <a href="#" class="active">Dashboard</a>
            <a href="#">Admin Profile</a>
            <a href="#">Lihat Member</a>
            <a href="#">Tambah Member</a>
            <a href="#">Paket Member</a>
            <a href="#">Kelas Fitness</a>
            <a href="#">Coach</a>

            <button class="logout-button">Logout</button>
        </div>

  
        <div class="col-md-10 p-4">
            <div class="card card-custom mb-4 p-4 d-flex justify-content-between align-items-center flex-row">
                <div>
                    <h5>Selamat Datang, Admin!</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
                <img src="{{ asset('images/fortuna-logo.png') }}" alt="Fortuna Logo" height="50">
            </div>

            <h5 class="mb-3">Member Aktif</h5>
            <div class="member-card mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <input type="text" class="search-bar" placeholder="Search">
                    <i class="fas fa-search text-white"></i>
                </div>
                <table class="table table-borderless text-white">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Tanggal Bayar</th>
                            <th>Tanggal Berakhir</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="circle"></span> James Medalla</td>
                            <td>-</td>
                            <td>-</td>
                            <td><i class="fas fa-ellipsis-v"></i></td>
                        </tr>
                        <tr>
                            <td><span class="circle"></span> Kent Charl Mabutas</td>
                            <td>-</td>
                            <td>-</td>
                            <td><i class="fas fa-ellipsis-v"></i></td>
                        </tr>
                        <tr>
                            <td><span class="circle"></span> John Elmar Rodrigo</td>
                            <td>-</td>
                            <td>-</td>
                            <td><i class="fas fa-ellipsis-v"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-custom p-3">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Coaches</h6>
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                        <div><span class="circle-coach"></span> Juan Dela Cruz</div>
                        <div><span class="circle-coach"></span> Peter</div>
                        <div><span class="circle-coach"></span> Peter</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-custom p-3">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Kelas Fitness</h6>
                            <i class="fas fa-ellipsis-v"></i>
                        </div>
                        <div><span class="circle-coach"></span> Zumba</div>
                        <div><span class="circle-coach"></span> Pound Fit</div>
                        <div><span class="circle-coach"></span> Dance</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div> --}}
@endsection
