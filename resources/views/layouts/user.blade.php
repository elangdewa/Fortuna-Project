
@extends('layouts.app')

@section('content')
    <div class="d-flex">
        @include('layouts.usernavbar') {{-- Sidebar khusus admin --}}
        
        <div class="main-content">
            @yield('user-content') {{-- Konten halaman admin --}}
        </div>
    </div>
@endsection
