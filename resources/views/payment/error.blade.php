
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
        <div class="text-center">
            <svg class="w-16 h-16 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>

            <h2 class="text-2xl font-bold mt-4">Pembayaran Gagal</h2>

            <p class="text-gray-600 mt-2">
                Maaf, terjadi kesalahan dalam proses pembayaran Anda.
            </p>

            <div class="mt-8">
                <a href="{{ route('user.member') }}" class="inline-block px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Kembali ke Halaman Member
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
