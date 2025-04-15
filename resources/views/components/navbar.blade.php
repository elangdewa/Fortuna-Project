@vite(['resources/sass/app.scss', 'resources/js/app.js'])
<link href="{{ asset('css/navbar.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<header class="custom-header text-white py-3">
    <div class="container d-flex align-items-center justify-content-between">
        <a href="/">
            <img src="{{ asset('images/LOGO.png') }}" class="logo" alt="Logo">
        </a>

        <!-- Navigasi Tengah -->
        <nav class="nav-center d-none d-lg-block">
            <ul class="nav">
                <li class="nav-item"><a href="/Fitness" class="nav-link text-white">Kelas Fitness</a></li>
                <li class="nav-item"><a href="/membership" class="nav-link text-white">Membership</a></li>
                <li class="nav-item"><a href="/about" class="nav-link text-white">Tentang Kami</a></li>
            </ul>
        </nav>

        <!-- Login & Register -->
        <div class="nav-auth d-none d-lg-block">
            <ul class="nav">
                <li class="nav-item"><a href="/Fitness" class="nav-link btn btn-success text-white">Login</a></li>
                <li class="nav-item"><a href="#" class="nav-link btn btn-success text-white">Register</a></li>
            </ul>
        </div>

        <!-- Tombol Menu Mobile -->
        <button class="navbar-toggler d-lg-none" id="menuToggle">
            ☰
        </button>
    </div>

    <!-- Menu Mobile (default: hidden) -->
    <div class="mobile-menu d-lg-none" id="mobileMenu">
        <ul class="nav flex-column text-center">
            <li class="nav-item"><a href="/Fitness" class="nav-link text-white">Kelas Fitness</a></li>
            <li class="nav-item"><a href="/membership" class="nav-link text-white">Membership</a></li>
            <li class="nav-item"><a href="/about" class="nav-link text-white">Tentang Kami</a></li>
            <li class="nav-item"><a href="#" class="nav-link btn btn-success text-white">Login</a></li>
            <li class="nav-item"><a href="#" class="nav-link btn btn-success text-white">Register</a></li>
        </ul>
    </div>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let menu = document.getElementById("mobileMenu");
        let toggleButton = document.getElementById("menuToggle");

        if (!menu || !toggleButton) {
            console.error("Elemen menu atau tombol tidak ditemukan!");
            return;
        }

        toggleButton.addEventListener("click", function(event) {
            event.stopPropagation();
            menu.classList.toggle("active");
        });

        document.addEventListener("click", function(event) {
            if (!menu.contains(event.target) && !toggleButton.contains(event.target)) {
                menu.classList.remove("active");
            }
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>