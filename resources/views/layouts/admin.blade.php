{{-- resources/views/layouts/admin.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="d-flex">
        @include('layouts.sidenavbar')

        <div class="main-content">
            @yield('admin-content') 
        </div>
    </div>
@endsection
