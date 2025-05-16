
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
        <div class="text-center">
            <svg class="w-16 h-16 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>

            <h2 class="text-2xl font-bold mt-4">Pembayaran Berhasil!</h2>

            <p class="text-gray-600 mt-2">
                Terima kasih atas pembayaran Anda. Sistem sedang memverifikasi pembayaran Anda.
            </p>

            <div class="mt-6" id="loading">
                <div class="animate-spin rounded-full h-10 w-10 border-t-2 border-b-2 border-blue-500 mx-auto"></div>
                <p class="text-gray-500 mt-2">Memverifikasi pembayaran...</p>
            </div>

            <div class="mt-6 hidden" id="success">
                <p class="text-green-500">✓ Verifikasi selesai</p>
                <a href="{{ route('user.member') }}" class="inline-block mt-4 px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Kembali ke Halaman Member
                </a>
            </div>

            <div class="mt-8">
                <p class="text-sm text-gray-500">
                    Order ID: <span class="font-mono">{{ $order_id }}</span>
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const orderId = '{{ $order_id }}';
    const loading = document.getElementById('loading');
    const success = document.getElementById('success');

    fetch('{{ route("payment.verify") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            order_id: orderId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loading.classList.add('hidden');
            success.classList.remove('hidden');
        } else {
            alert('Terjadi kesalahan saat verifikasi: ' + (data.error || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Verification error:', error);
        alert('Terjadi kesalahan saat verifikasi pembayaran');
    });
});
</script>
@endpush
@endsection
