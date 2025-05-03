<link href="{{ asset('css/admin.css') }}" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<!-- layouts/sidenavbar.blade.php -->
<div class="d-flex">

    <button class="mobile-toggle d-md-none" id="mobileToggle">
        <i class="bi bi-list"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Toggle Sidebar Button -->
        <button class="toggle-sidebar" id="toggleSidebar">
            <i class="bi bi-layout-sidebar" id="toggleIcon"></i>
        </button>

        <div class="text-center text-white py-3">
            <h2 class="m-0 fs-4">Selamat Datang, {{ auth()->user()->name }}</h2>
        </div>
        
        <!-- Admin Profile -->
        <div class="admin-profile">
            <i class="bi bi-person-circle"></i>
            <h5 class="mt-2">Admin</h5>
        </div>

        <!-- Menu Navigation -->
        <nav class="nav flex-column w-100 px-3">
            <a href="{{ route('admin.admin') }}" class="nav-link tooltip-sidebar {{ Request::is('admin') ? 'active' : '' }}" data-title="Dashboard">
                <i class="bi bi-speedometer2"></i>
                <span class="ms-2">Dashboard</span>
            </a>
            <a href="{{ route('admin.profile') }}" class="nav-link tooltip-sidebar {{ Request::is('admin/profile') ? 'active' : '' }}" data-title="Profil Admin">
                <i class="bi bi-person"></i>
                <span class="ms-2">Profil Admin</span>
            </a>
            <a href="{{ route('members.view') }}" class="nav-link tooltip-sidebar {{ Request::is('admin/members/view') ? 'active' : '' }}" data-title="Lihat Member">
                <i class="bi bi-people"></i>
                <span class="ms-2">Lihat Member</span>
            </a>
            <a href="{{ route('members.create') }}" class="nav-link tooltip-sidebar {{ Request::is('admin/members/create') ? 'active' : '' }}" data-title="Tambah Member">
                <i class="bi bi-person-plus"></i>
                <span class="ms-2">Tambah Member</span>
            </a>
            <a href="{{ route('admin.paketmember.index') }}" class="nav-link tooltip-sidebar {{ Request::is('admin/paketmember') ? 'active' : '' }}" data-title="Paket Member">
                <i class="bi bi-box-seam"></i>
                <span class="ms-2">Paket Member</span>
            </a>
            <a href="{{ route('admin.fitness.index') }}" class="nav-link tooltip-sidebar {{ Request::is('admin/fitness') ? 'active' : '' }}" data-title="Kelas Fitness">
                <i class="bi bi-bicycle"></i>
                <span class="ms-2">Kelas Fitness</span>
            </a>
            <a href="{{ route('admin.trainers.index') }}" class="nav-link tooltip-sidebar {{ Request::is('admin/trainer') ? 'active' : '' }}" data-title="Coach">
                <i class="bi bi-person-badge"></i>
                <span class="ms-2">Coach</span>
            </a>
        </nav>

        <!-- Logout -->
        <form action="{{ route('logout') }}" method="POST" class="mt-auto w-100 px-3">
            @csrf
            <button type="submit" class="logout-button tooltip-sidebar" data-title="Keluar">
                <i class="bi bi-box-arrow-right"></i>
                <span class="ms-2">Keluar</span>
            </button>
        </form>
    </div>

    <!-- Main Content Container -->
    <div class="main-content" id="mainContent">
        @yield('sidebar-content')
    </div>
</div>

<script>document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleButton = document.getElementById('toggleSidebar');
    const toggleIcon = document.getElementById('toggleIcon');
    const toggleText = document.getElementById('toggleText');
    const mobileToggle = document.getElementById('mobileToggle');

    // Set status awal
    const sidebarState = localStorage.getItem('sidebarCollapsed');
    if (sidebarState === 'true') {
        sidebar.classList.add('collapsed');
        mainContent.classList.add('expanded');
        if (toggleText) toggleText.textContent = 'Buka Menu';
        toggleIcon.classList.replace('bi-layout-sidebar', 'bi-layout-sidebar-inset-reverse');
    }

    // Toggle sidebar
    toggleButton.addEventListener('click', function(e) {
        e.preventDefault();
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');

        const isCollapsed = sidebar.classList.contains('collapsed');
        localStorage.setItem('sidebarCollapsed', isCollapsed);

        if (toggleText) {
            toggleText.textContent = isCollapsed ? 'Buka Menu' : 'Tutup Menu';
        }
        toggleIcon.classList.toggle('bi-layout-sidebar');
        toggleIcon.classList.toggle('bi-layout-sidebar-inset-reverse');
    });

    // Mobile toggle
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function(e) {
            e.preventDefault();
            sidebar.classList.toggle('mobile-visible');
        });
    }

    // Close sidebar when clicking outside
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 768 && 
            !sidebar.contains(event.target) && 
            !mobileToggle.contains(event.target) && 
            sidebar.classList.contains('mobile-visible')) {
            sidebar.classList.remove('mobile-visible');
        }
    });

    // Handle resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('mobile-visible');
        }
    });
});</script>
