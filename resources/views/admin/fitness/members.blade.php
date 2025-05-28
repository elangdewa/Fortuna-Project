@extends('layouts.app')

@section('content')
<link href="{{ asset('css/member.css') }}" rel="stylesheet">
@include('layouts.sidenavbar')

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Member Kelas: {{ $class->class_name }}</h2>
        <a href="{{ route('admin.fitness.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Member</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Tanggal Registrasi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $registration)
                            <tr>
                                <td>{{ $registration->user->id }}</td>
                                <td>{{ $registration->user->name }}</td>
                                <td>{{ $registration->user->email }}</td>
                                <td>{{ $registration->user->phone }}</td>
                                <td>{{ $registration->registered_at->format('d M Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-{{ $registration->status === 'active' ? 'success' : 'warning' }}">
                                        {{ ucfirst($registration->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada member yang terdaftar</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
