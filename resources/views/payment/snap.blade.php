@extends('layouts.app')

@section('content')
<script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    window.snap.pay("{{ $snapToken }}", {
        onSuccess: function(result){
            window.location.href = "/payment/status/{{ $orderId }}";
        },
        onPending: function(result){
            alert('Transaksi tertunda');
        },
        onError: function(result){
            alert('Terjadi error saat pembayaran');
        },
        onClose: function(){
            alert('Kamu menutup pembayaran');
        }
    });
</script>
@endsection
