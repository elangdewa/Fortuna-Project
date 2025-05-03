{{-- resources/views/layouts/admin.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="d-flex">
        @include('layouts.sidenavbar') {{-- Sidebar khusus admin --}}
        
        <div class="main-content">
            @yield('admin-content') {{-- Konten halaman admin --}}
        </div>
    </div>
@endsection
