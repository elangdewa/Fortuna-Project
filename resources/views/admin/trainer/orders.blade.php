@extends('layouts.admin')

@section('admin-content')
<link href="{{ asset('css/tableadmin.css') }}" rel="stylesheet">


<div class="container mt-5">
   <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-3">Daftar Pesanan Personal Trainer</h2>
            <!-- Search Form -->
            <form action="{{ route('admin.trainer.orders') }}" method="GET">
                <div class="input-group" style="width: 300px;">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Cari nama member atau trainer..."
                           value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.trainer.orders') }}"
                           class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

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
                <th>Status Pembayaran</th>
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
                <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' :
                    ($order->payment_status === 'pending' ? 'warning' : 'danger') }}">
                    {{ ucfirst($order->payment_status) }}
                </span>
                </td>
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
<div class="d-flex justify-content-center mt-4">
    @if($orders->hasPages())
        <nav aria-label="Page navigation">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($orders->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">‹</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $orders->previousPageUrl() }}" rel="prev">‹</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                    @if ($page == $orders->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($orders->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $orders->nextPageUrl() }}" rel="next">›</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">›</span>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
</div>
@endsection
