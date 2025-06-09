@extends('layouts.admin')

@section('admin-content')
<link href="{{ asset('css/tableadmin.css') }}" rel="stylesheet">

<div class="main-content" id="mainContent">
    <div class="header-section">
        <div class="page-title">
            <i class="fas fa-users"></i>
            Daftar Member
        </div>
    </div>

    <!-- Search Section -->
    <div class="search-section">
        <form action="{{ route('members.view') }}" method="GET">
            <div class="search-wrapper">
                <div class="search-input">
                    <input type="text" name="search"
                           placeholder="Cari nama, email, atau no telepon..."
                           value="{{ request('search') }}">
                    <button type="submit">
                        <i class="fas fa-search"></i>
                        <span class="d-none d-md-inline ms-1">Cari</span>
                    </button>
                </div>
                <a href="{{ route('members.view') }}" class="reset-btn">
                    <i class="fas fa-undo"></i>
                    <span class="d-none d-md-inline ms-1">Reset</span>
                </a>
            </div>
        </form>
    </div>

<a href="{{ route('admin.export.memberships') }}" class="btn btn-success mb-3">
    <i class="bi bi-file-earmark-excel"></i> Export Memberships
</a>

    <!-- Table Section -->
    <div class="table-section">
        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="th-foto text-center">
                            <i class="fas fa-image me-1"></i>Foto
                        </th>
                        <th class="th-nama">
                            <i class="fas fa-user me-1"></i>Nama
                        </th>
                        <th class="th-email d-none d-lg-table-cell">
                            <i class="fas fa-envelope me-1"></i>Email
                        </th>
                        <th class="th-telepon d-none d-md-table-cell">
                            <i class="fas fa-phone me-1"></i>Telepon
                        </th>
                        <th class="th-alamat d-none d-xl-table-cell">
                            <i class="fas fa-map-marker-alt me-1"></i>Alamat
                        </th>
                        <th class="th-membership text-center">
                            <i class="fas fa-crown me-1"></i>Membership
                        </th>
                        <th class="th-status text-center">
                            <i class="fas fa-circle me-1"></i>Status
                        </th>
                        <th class="th-tanggal d-none d-lg-table-cell text-center">
                            <i class="fas fa-calendar-plus me-1"></i>Mulai
                        </th>
                        <th class="th-tanggal d-none d-lg-table-cell text-center">
                            <i class="fas fa-calendar-times me-1"></i>Berakhir
                        </th>
                        <th class="th-aksi text-center">
                            <i class="fas fa-cogs me-1"></i>Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                        <tr class="table-row-hover">
                            <td class="text-center">
                                <div class="profile-container">
                                    @if ($member->profile_photo)
                                        <img src="{{ asset('storage/profile_photos/' . $member->profile_photo) }}"
                                            alt="{{ $member->name }}" class="profile-image"
                                            title="{{ $member->name }}">
                                    @else
                                        <div class="profile-initial" title="{{ $member->name }}">
                                            {{ strtoupper(substr($member->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="member-info">
                                    <div class="fw-bold text-truncate-custom"
                                        title="{{ $member->name }}">{{ $member->name }}</div>
                                    <small class="text-muted d-lg-none text-truncate-custom"
                                        title="{{ $member->email }}">
                                        <i class="fas fa-envelope me-1"></i>{{ $member->email }}
                                    </small>
                                    <small class="text-muted d-md-none d-block">
                                        <i class="fas fa-phone me-1"></i>{{ $member->phone }}
                                    </small>
                                </div>
                            </td>
                            <td class="d-none d-lg-table-cell">
                                <span class="text-truncate-custom" title="{{ $member->email }}">
                                    <i class="fas fa-envelope me-2 text-muted"></i>{{ $member->email }}
                                </span>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <span title="{{ $member->phone }}">
                                    <i class="fas fa-phone me-2 text-muted"></i>{{ $member->phone }}
                                </span>
                            </td>
                            <td class="d-none d-xl-table-cell">
                                <span class="text-truncate-custom" title="{{ $member->address }}">
                                    <i class="fas fa-map-marker-alt me-2 text-muted"></i>{{ $member->address }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary-custom text-truncate-custom"
                                    title="{{ $member->membership->type->name ?? 'Tidak Ada' }}">
                                    <i class="fas fa-crown me-1"></i>
                                    {{ Str::limit($member->membership->type->name ?? 'Tidak Ada', 8) }}
                                </span>
                            </td>
                            <td class="text-center">
                              <span class="badge status-badge
    @if (optional($member->membership)->status == 'active') bg-success
    @elseif(optional($member->membership)->status == 'expired') bg-danger
    @else bg-warning @endif">
    @if (optional($member->membership)->status == 'active')
        <i class="fas fa-check-circle me-1"></i>
    @elseif(optional($member->membership)->status == 'expired')
        <i class="fas fa-times-circle me-1"></i>
    @else
        <i class="fas fa-clock me-1"></i>
    @endif
    {{ ucfirst(optional($member->membership)->status ?? 'inactive') }}
</span>

                            </td>
                            <td class="d-none d-lg-table-cell text-center">
                                <div class="date-info">
                                    <i class="fas fa-calendar-plus me-1 text-muted"></i>
                                    <small class="fw-semibold">
                                        {{ $member->membership->start_date ? \Carbon\Carbon::parse($member->membership->start_date)->format('d/m/Y') : '-' }}
                                    </small>
                                </div>
                            </td>
                            <td class="d-none d-lg-table-cell text-center">
                                <div class="date-info">
                                    <i class="fas fa-calendar-times me-1 text-muted"></i>
                                    <small class="fw-semibold">
                                        {{ $member->membership->end_date ? \Carbon\Carbon::parse($member->membership->end_date)->format('d/m/Y') : '-' }}
                                    </small>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="action-group">
                                    {{-- <button class="btn btn-sm btn-outline-primary"
                                            onclick="viewMember({{ $member->id }})"
                                            title="Lihat Detail" data-bs-toggle="tooltip">
                                       <i class="bi bi-eye-fill"></i>
                                    </button> --}}
                                    <a href="{{ route('admin.members.edit', $member->id) }}"
                                        class="btn btn-sm btn-outline-primary"
                                        title="Edit Member" data-bs-toggle="tooltip">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.members.destroy', $member->id) }}"
                                        method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-btn"
                                            title="Hapus Member" data-bs-toggle="tooltip">
                                         <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-users-slash"></i>
                                    <h5 class="text-muted mb-2">Tidak ada member ditemukan</h5>
                                    <p class="text-muted mb-0">
                                        @if(request('search'))
                                            Tidak ditemukan hasil untuk "<strong>{{ request('search') }}</strong>"
                                        @else
                                            Belum ada member yang terdaftar
                                        @endif
                                    </p>
                                    <div class="mt-3">
                                        @if(request('search'))
                                            <a href="{{ route('members.view') }}" class="btn btn-primary-custom btn-sm">
                                                <i class="fas fa-undo me-1"></i>Lihat Semua Member
                                            </a>
                                        @else
                                            <button class="btn btn-primary-custom btn-sm">
                                                <i class="fas fa-plus me-1"></i>Tambah Member Baru
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <!-- Mobile Action Button -->
    <div class="mobile-fab d-md-none">
        <button class="btn btn-primary-custom rounded-circle shadow"
                data-bs-toggle="modal" data-bs-target="#mobileFilterModal"
                title="Filter & Actions">
            <i class="fas fa-filter"></i>
        </button>
    </div>


<!-- Member Detail Modal -->
{{-- <div class="modal fade" id="memberDetailModal" tabindex="-1" aria-labelledby="memberDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="memberDetailModalLabel">
                    <i class="fas fa-user me-2"></i>Detail Member
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="memberDetailContent">
                <!-- Content will be loaded here -->
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<!-- Mobile Filter Modal -->
<div class="modal fade" id="mobileFilterModal" tabindex="-1" aria-labelledby="mobileFilterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mobileFilterModalLabel">
                    <i class="fas fa-filter me-2"></i>Filter & Actions
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-download me-2"></i>Export Data
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Handle sidebar toggle
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const body = document.body;

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            body.classList.toggle('sidebar-collapsed');
        });
    }

    // Enhanced delete confirmation
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus member ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'animated fadeInDown'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = this.closest('.delete-form');
                    if (form) {
                        form.submit();
                    }
                }
            });
        });
    });

    // View member detail function
    // window.viewMember = function(memberId) {
    //     $('#memberDetailModal').modal('show');

    //     setTimeout(() => {
    //         document.getElementById('memberDetailContent').innerHTML = `
    //             <div class="text-center">
    //                 <h6>Member ID: ${memberId}</h6>
    //                 <p>Detail akan dimuat di sini...</p>
    //             </div>
    //         `;
    //     }, 1000);
    // };

    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                // Auto-submit after 500ms of no typing
                // Uncomment if you want auto-search
                // this.form.submit();
            }, 500);
        });
    }



    const tableRows = document.querySelectorAll('.table-row-hover');
    tableRows.forEach(row => {
        row.addEventListener('click', function(e) {
            // Don't trigger if clicking on buttons
            if (!e.target.closest('button') && !e.target.closest('a')) {
                row.style.background = 'rgba(218, 145, 0, 0.1)';
                setTimeout(() => {
                    row.style.background = '';
                }, 300);
            }
        });
    });
});


function exportData() {
    // Export functionality
    console.log('Export data...');
}


</script>

<!-- Add SweetAlert2 for better alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
