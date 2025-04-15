<link href="{{ asset('css/footer.css') }}" rel="stylesheet">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">


<footer class="footer text-white py-4">
    <div class="container">
        <div class="row align-items-center">
            <!-- Logo dan Informasi -->
            <div class="col-lg-6 text-lg-start text-center">
                <div class="d-flex flex-column align-items-lg-start align-items-center">
                    <a href="/">
                        <img src="{{ asset('images/LOGO.png') }}" class="logo" alt="Logo">
                    </a>
                    <h5 class="fw-bold">Mulai Sekarang, Jadi Lebih Baik Setiap Hari!</h5>
                    <div class="footer-menu d-flex gap-3">
                        <a href="/Fitness" class="text-white text-decoration-none">Kelas Fitness</a>
                        <a href="#" class="text-white text-decoration-none">Membership</a>
                        <a href="#" class="text-white text-decoration-none">Tentang Kami</a>
                    </div>
                    <p class="mt-2">
                        <i class="bi bi-geo-alt-fill"></i> Jl. Belahan Wedoro No. 10 Waru, Sidoarjo
                    </p>
                    <p class="mb-0"><i class="bi bi-telephone-fill"></i> <strong>0812345678912</strong></p>
                </div>
            </div>

            <!-- Jam Operasional dan Sosial Media -->
            <div class="col-lg-6 text-lg-end text-center mt-4 mt-lg-0">
                <h6 class="fw-bold">Jam Operasional</h6>
                <p class="mb-1">Setiap Hari</p>
                <p>06.00 - 22.00</p>
                <h6 class="fw-bold">Hubungi Kami Sekarang!</h6>
                <div class="social-icons d-flex justify-content-lg-end justify-content-center gap-3">
                    <a href="#" class="text-white fs-4"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-white fs-4"><i class="bi bi-whatsapp"></i></a>
                    <a href="#" class="text-white fs-4"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>

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

