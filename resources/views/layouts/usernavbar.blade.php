<link href="{{ asset('css/admin.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<div class="d-flex">
    <!-- Mobile Toggle Button -->
    <button class="mobile-toggle d-md-none" id="mobileToggle">
        <i class="bi bi-toggle-off" id="mobileToggleIcon"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Header with Welcome Text and Toggle Button -->
        <div class="d-flex justify-content-between align-items-center text-white px-3 py-3">
            <h2 class="m-0 fs-5">Selamat Datang, {{ auth()->user()->name }}</h2>
            <button class="toggle-sidebar ms-2" id="toggleSidebar">
                <i class="bi bi-toggle-off" id="toggleIcon"></i>
            </button>
        </div>

        <!-- Profile Picture -->
        <div class="text-center text-white px-3">
            <div class="profile-picture mt-2">
                @if(auth()->user()->profile_photo)
                    <img src="{{ asset('storage/profile_photos/' . auth()->user()->profile_photo) }}"
                         alt="Foto Profil"
                         class="rounded-circle"
                         style="width: 100px; height: 100px; object-fit: cover;">
                @else
                    <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center"
                         style="width: 100px; height: 100px;">
                        <span class="text-white fs-3">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                @endif
            </div>

            @php
                $membership = auth()->user()->membership;
            @endphp

            @if ($membership && $membership->status != 'inactive')
                <p class="text-white m-0 mt-2">
                    Membership:
                    <span class="badge
                        @if($membership->status == 'active') bg-success
                        @elseif($membership->status == 'expired') bg-danger
                        @else bg-warning @endif">
                        {{ ucfirst($membership->status) }}
                    </span>
                </p>
            @else
                <p class="text-white m-0 mt-2">
                    <span class="badge bg-secondary">Belum jadi member</span>
                </p>
            @endif
        </div>

        <!-- Menu Navigation -->
        <nav class="nav flex-column w-100 px-3 mt-3">
            <a href="{{ route('user.home') }}" class="nav-link tooltip-sidebar {{ Request::is('user/home') ? 'active' : '' }}" data-title="Beranda">
                <i class="bi bi-house-door"></i>
                <span class="ms-2">Beranda</span>
            </a>
            <a href="{{ route('user.fitness') }}" class="nav-link tooltip-sidebar {{ Request::is('user/fitness') ? 'active' : '' }}" data-title="Kelas Fitness">
                <i class="bi bi-person-arms-up"></i>
                <span class="ms-2">Kelas Fitness</span>
            </a>
            <a href="{{ route('user.member') }}" class="nav-link tooltip-sidebar {{ Request::is('user/member') ? 'active' : '' }}" data-title="Membership">
                <i class="bi bi-person-vcard"></i>
                <span class="ms-2">Membership</span>
            </a>
            <a href="{{ route('user.trainer') }}" class="nav-link tooltip-sidebar {{ Request::is('user/trainer') ? 'active' : '' }}" data-title="Pelatih Pribadi">
                <i class="bi bi-person-lines-fill"></i>
                <span class="ms-2">Pelatih Pribadi</span>
            </a>
            <a href="{{ route('user.setting') }}" class="nav-link tooltip-sidebar {{ Request::is('user/setting') ? 'active' : '' }}" data-title="Pengaturan">
                <i class="bi bi-gear"></i>
                <span class="ms-2">Pengaturan</span>
            </a>

            <!-- Logout -->
            <form action="{{ route('logout') }}" method="POST" class="mt-auto w-100">
                @csrf
                <button type="submit" class="logout-button tooltip-sidebar" data-title="Keluar">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="ms-2">Keluar</span>
                </button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        @yield('sidebar-content')
    </div>
</div>

<!-- Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleButton = document.getElementById('toggleSidebar');
    const mobileToggle = document.getElementById('mobileToggle');
    const toggleIcon = document.getElementById('toggleIcon');
    const mobileToggleIcon = document.getElementById('mobileToggleIcon');

    const sidebarState = localStorage.getItem('sidebarCollapsed');
    if (sidebarState === 'true') {
        sidebar.classList.add('collapsed');
        mainContent.classList.add('expanded');
        toggleIcon.classList.replace('bi-toggle-off', 'bi-toggle-on');
        mobileToggleIcon.classList.replace('bi-toggle-off', 'bi-toggle-on');
    }

    toggleButton.addEventListener('click', function (e) {
        e.preventDefault();
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
        const isCollapsed = sidebar.classList.contains('collapsed');
        localStorage.setItem('sidebarCollapsed', isCollapsed);
        toggleIcon.classList.toggle('bi-toggle-off');
        toggleIcon.classList.toggle('bi-toggle-on');
    });

    if (mobileToggle) {
        mobileToggle.addEventListener('click', function (e) {
            e.preventDefault();
            sidebar.classList.toggle('mobile-visible');
            mobileToggleIcon.classList.toggle('bi-toggle-off');
            mobileToggleIcon.classList.toggle('bi-toggle-on');
        });
    }

    document.addEventListener('click', function (event) {
        if (window.innerWidth <= 768 &&
            !sidebar.contains(event.target) &&
            !mobileToggle.contains(event.target) &&
            sidebar.classList.contains('mobile-visible')) {
            sidebar.classList.remove('mobile-visible');
            mobileToggleIcon.classList.replace('bi-toggle-on', 'bi-toggle-off');
        }
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('mobile-visible');
            mobileToggleIcon.classList.replace('bi-toggle-on', 'bi-toggle-off');
        }
    });
});
</script>
