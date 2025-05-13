@extends('layouts.app')
@section('content')
<link href="{{ asset('css/member.css') }}" rel="stylesheet">

@include('layouts.sidenavbar')

<div class="container mt-5">
    <h2>Daftar Pesanan Personal Trainer</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Nama User</th>
                <th>Trainer</th>
                <th>Catatan</th>
                <th>Tanggal Pesan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->trainer->name }}</td>
                <td>{{ $order->notes }}</td>
                <td>{{ $order->order_date }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>
                    <form action="{{ route('admin.trainer-orders.update', $order->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $order->status === 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $order->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </form>

                    <form action="{{ route('admin.trainer-orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pesanan ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection