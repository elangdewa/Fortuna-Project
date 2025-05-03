<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
    @include('layouts.navbar')

    <!-- Background dengan overlay -->
    <div class="login-background">
        <div class="overlay"></div>

        <div class="form-wrapper">
            <div class="login-form card">
                <div class="card-body">
                    <h2 class="text-center mb-4">Login</h2>
                    <form>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="email" class="form-control" id="email" placeholder="Masukkan Email" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="password" placeholder="Masukkan password" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <p class="mb-0">Belum Punya Akun?</p>
                                <a href="#" class="text-decoration-none medium">Daftar Sekarang</a>
                            </div>
                            <a href="#" class="text-decoration-none small">Lupa Password?</a>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')

    @vite('resources/js/app.js')
</body>
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
</html>
