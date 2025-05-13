@vite(['resources/sass/app.scss', 'resources/js/app.js'])
<link href="{{ asset('css/navbar.css') }}" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
                <li class="nav-item"><a href="{{ route('login') }}" class="nav-link btn btn-success text-white">Login</a></li>
                <li class="nav-item"><a href="/register" class="nav-link btn btn-success text-white">Register</a></li>
            </ul>
        </div>

       
        <button id="menuToggle" class="d-lg-none">
            <i class="bi bi-list fs-4"></i>
        </button>
    </div>

    <!-- Menu Mobile (default: hidden) -->
    <div class="mobile-menu" id="mobileMenu">
        <ul class="nav flex-column">
            <li class="nav-item"><a href="/Fitness" class="nav-link text-white"><i class="bi bi-lightning-fill me-2"></i>Kelas Fitness</a></li>
            <li class="nav-item"><a href="/membership" class="nav-link text-white"><i class="bi bi-card-checklist me-2"></i>Membership</a></li>
            <li class="nav-item"><a href="/about" class="nav-link text-white"><i class="bi bi-info-circle-fill me-2"></i>Tentang Kami</a></li>
            <li class="nav-item auth-item">
                <a href="{{ route('login') }}" class="nav-link btn btn-success text-white"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a>
            </li>
            <li class="nav-item auth-item">
                <a href="/register" class="nav-link btn btn-success text-white"><i class="bi bi-person-plus-fill me-2"></i>Register</a>
            </li>
        </ul>
    </div>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("DOM loaded - checking mobile menu functionality");

        const menu = document.getElementById("mobileMenu");
        const toggleButton = document.getElementById("menuToggle");
        const body = document.body;

        if (!menu || !toggleButton) {
            console.error("Elemen menu atau tombol tidak ditemukan!");
            return;
        } else {
            console.log("Menu dan tombol toggle ditemukan");
        }

        toggleButton.addEventListener("click", function(event) {
            console.log("Tombol toggle diklik");
            event.preventDefault();
            event.stopPropagation();

            menu.classList.toggle("active");
            body.classList.toggle("menu-open"); // Prevent scrolling when menu is open

            // Change icon based on menu state
            const icon = this.querySelector("i");
            if (icon) {
                if (menu.classList.contains("active")) {
                    icon.classList.remove("bi-list");
                    icon.classList.add("bi-x-lg");
                    console.log("Ikon diubah ke X");
                } else {
                    icon.classList.remove("bi-x-lg");
                    icon.classList.add("bi-list");
                    console.log("Ikon diubah ke list");
                }
            }
        });

        // Close menu when clicking outside
        document.addEventListener("click", function(event) {
            if (menu.classList.contains("active") && !menu.contains(event.target) && !toggleButton.contains(event.target)) {
                console.log("Klik diluar menu, menutup menu");
                menu.classList.remove("active");
                body.classList.remove("menu-open");

                // Reset icon
                const icon = toggleButton.querySelector("i");
                if (icon) {
                    icon.classList.remove("bi-x-lg");
                    icon.classList.add("bi-list");
                }
            }
        });

        // Close menu when a link is clicked
        const menuLinks = menu.querySelectorAll("a");
        menuLinks.forEach(link => {
            link.addEventListener("click", function() {
                console.log("Link di menu diklik, menutup menu");
                menu.classList.remove("active");
                body.classList.remove("menu-open");

                // Reset icon
                const icon = toggleButton.querySelector("i");
                if (icon) {
                    icon.classList.remove("bi-x-lg");
                    icon.classList.add("bi-list");
                }
            });
        });

        // Handle window resize - close mobile menu if window gets larger
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 992 && menu.classList.contains('active')) {
                menu.classList.remove('active');
                body.classList.remove("menu-open");

                const icon = toggleButton.querySelector("i");
                if (icon) {
                    icon.classList.remove("bi-x-lg");
                    icon.classList.add("bi-list");
                }
            }
        });
    });
</script>
