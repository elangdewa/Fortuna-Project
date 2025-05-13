@extends('layouts.user')

@section('user-content')
<div class="container mt-5">
    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" id="trainerTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="choose-tab" data-bs-toggle="tab" data-bs-target="#choose-trainer" type="button" role="tab">
                Pilih Trainer
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#my-orders" type="button" role="tab">
                Pesanan Saya
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="trainerTabsContent">
        <!-- Tab 1: Pilih Trainer -->
        <div class="tab-pane fade show active" id="choose-trainer" role="tabpanel">
            <h1 class="text-center mb-4">Pilih Personal Trainer Terbaik!</h1>
            <p class="text-center mb-5">Pilih personal trainer yang sesuai dengan kebutuhan dan tujuan fitnessmu untuk hasil yang lebih maksimal</p>

            <div class="row">
                @foreach($trainers as $trainer)
                <div class="col-md-6 mb-4">
                    <div class="card trainer-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h3 class="card-title">{{ $loop->iteration }}. {{ $trainer->name }}</h3>
                                    <h5 class="card-subtitle mb-2 ">Spesialisasi</h5>
                                </div>
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderModal-{{ $trainer->id }}">
                                    Pilih Trainer
                                </button>
                            </div>
                            <p class="trainer-experience">Pengalaman: {{ $trainer->experience }}</p>
                        </div>
                    </div>
                </div>

                <!-- Modal untuk setiap trainer -->
                <div class="modal fade" id="orderModal-{{ $trainer->id }}" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="orderModalLabel">Pesan Trainer {{ $trainer->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('user.trainer-orders.store') }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <input type="hidden" name="trainer_id" value="{{ $trainer->id }}">
                                    
                                    <div class="mb-3">
                                        <label for="order_date-{{ $trainer->id }}" class="form-label">Tanggal Pesan</label>
                                        <input type="date" class="form-control" id="order_date-{{ $trainer->id }}" name="order_date" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="notes-{{ $trainer->id }}" class="form-label">Catatan Khusus</label>
                                        <textarea class="form-control" id="notes-{{ $trainer->id }}" name="notes" rows="3" placeholder="Masukkan catatan khusus untuk trainer"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Konfirmasi Pesanan</button>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Tab 2: Daftar Pesanan -->
        <div class="tab-pane fade" id="my-orders" role="tabpanel">
            <h2 class="mb-4">Daftar Pesanan Trainer Saya</h2>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="list-group">
                @foreach($orders as $order)
                <div class="list-group-item mb-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>{{ $order->trainer->name }}</h5>
                            <p>Tanggal: {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</p>
                            <p>Status: <span class="badge bg-{{ $order->status === 'approved' ? 'success' : ($order->status === 'rejected' ? 'danger' : 'warning') }}">
                                {{ ucfirst($order->status) }}
                            </span></p>
                            @if($order->notes)
                                <p class="mb-0">Catatan: {{ $order->notes }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set tanggal minimum ke hari ini
        const today = new Date().toISOString().split('T')[0];
        document.querySelectorAll('input[type="date"]').forEach(input => {
            input.min = today;
        });

        // Aktifkan tab jika ada hash di URL
        if (window.location.hash === '#my-orders') {
            const triggerEl = document.querySelector('#orders-tab');
            if (triggerEl) {
                const tab = new bootstrap.Tab(triggerEl);
                tab.show();
            }
        }

        // Di dalam form submit modal
        document.querySelectorAll('.modal form').forEach(form => {
            form.addEventListener('submit', function() {
                localStorage.setItem('activeTab', '#my-orders');
            });
        });

        // Saat load halaman
        const savedTab = localStorage.getItem('activeTab');
        if (savedTab === '#my-orders') {
            const triggerEl = document.querySelector('#orders-tab');
            if (triggerEl) {
                const tab = new bootstrap.Tab(triggerEl);
                tab.show();
            }
            localStorage.removeItem('activeTab');
        }
    });

</script>

<style>
    .trainer-card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: none;
        transition: transform 0.3s;
        padding: 20px;
    }

    .trainer-card:hover {
        transform: translateY(-5px);
    }

    .card-title {
        font-weight: bold;
        color: #333;
    }

    .card-subtitle {
        font-weight: 500;
        color: #080808;
    }

    .btn-outline-primary {
        border-radius: 20px;
        padding: 8px 20px;
    }

   

.trainer-card .card-body .trainer-experience {
    color: #000 !important;
      font-weight: 600;
    margin-top: 10px;
    font-size: 1rem;
}
    
    .modal-content {
        border-radius: 15px;
    }

    .nav-tabs {
        border-bottom: 2px solid #dee2e6;
    }

    .nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 500;
        padding: 10px 20px;
    }

    .nav-tabs .nav-link.active {
        color: #0d6efd;
        border-bottom: 3px solid #0d6efd;
        background-color: transparent;
        border-bottom: 3px solid #0d6efd;
    font-weight: 600;
    }

    .list-group-item {
        border-radius: 10px !important;
        margin-bottom: 10px;
        border: 1px solid rgba(0,0,0,.125);
    }

</style>

@endsection