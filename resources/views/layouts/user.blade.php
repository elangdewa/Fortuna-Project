
@extends('layouts.app')
    <link href="{{ asset('css/membership.css') }}" rel="stylesheet">

@section('content')
    <div class="d-flex">
        @include('layouts.usernavbar')

        <div class="main-content">
            @yield('user-content') {{-- Konten halaman admin --}}
        </div>
    </div>

@endsection
