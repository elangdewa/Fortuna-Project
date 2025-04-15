<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
    @include('components.navbar')

    <section class="bg-home">
        <div class="overlay">
            <div class="content">
                <h1>Bergerak lebih baik, hidup lebih berkualitas.</h1>
                <p>
                    Dengan kelas kebugaran bintang lima, peralatan canggih, dan staf yang ramah,
                    setiap kunjungan akan menjadi pengalaman yang menyenangkan dan menginspirasi.
                </p>
            </div>
        </div>
    </section>

<section class="container my-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <img src="{{ asset('images/section2.jpg') }}" alt="Fortuna Gym" class="img-fluid rounded shadow">
        </div>
        <div class="col-md-6">
            <h2 class="highlighted-text">MENGAPA FORTUNA FITNESS <br> PILIHAN TERBAIK</h2>
            <p>
                Fortuna Fitness menawarkan pengalaman olahraga terbaik dengan fasilitas modern, kelas beragam, dan komunitas suportif.
                Dengan akses ke semua cabang, jadwal fleksibel, serta instruktur profesional, Anda bisa mencapai target kebugaran dengan efektif.
                Lebih dari sekadar gym, Fortuna Fitness adalah gaya hidup sehat yang berkelanjutan.
            </p>
        </div>
    </div>
</section>

<section class="about-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="text-center about-text">
                <h2 class="about-title">Membership Mulai Dari 300.000/Bulan</h2>
                <p class="about-description">
                    Nikmati kebebasan berolahraga di Fortuna Fitness dengan fasilitas premium dan akses kelas sepuasnya!
                </p>
            </div>

            <!-- Bagian Kanan (Gambar & List) -->
            <div class="row justify-content-center about-content">
                <div class="col-lg-4 col-md-6 text-center about-item">
                    <img src="images/fitness.jpg" class="about-img">
                    <h4 class="about-heading">Berbagai Macam Kelas</h4>
                </div>
                <div class="col-lg-4 col-md-6 text-center about-item">
                    <img src="images/PT.jpg" class="about-img">
                    <h4 class="about-heading">Personal Trainer</h4>
                </div>
                <div class="col-lg-4 col-md-6 text-center about-item">
                    <img src="images/Komunitas.jpg" class="about-img">
                    <h4 class="about-heading">Komunitas Supportif</h4>
                </div>
            </div>
                <div class="text-center mt-3">
                    <a href="#" class="membership-btn">Lihat Membership</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container my-5">
    <div class="row g-4 justify-content-center">
        <h2 class="facility-title text-center">Fasilitas Eksklusif Untuk Pengalaman Terbaik!</h2>

        <!-- Baris atas (3 fasilitas) -->
        <div class="col-lg-4 col-md-6">
            <div class="feature-box">
                <h5><i class="bi bi-hdd-stack icon-small"></i> Peralatan Premium</h5>
                <p>Akses ke peralatan fitness terbaik dan modern.</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="feature-box">
                <h5><i class="bi bi-people-fill icon-small"></i> Pelatih Profesional</h5>
                <p>Pelatih bersertifikasi untuk membimbing perjalanan fitness Anda.</p>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="feature-box">
                <h5><i class="bi bi-droplet-fill icon-small"></i> Isi Ulang Air Gratis</h5>
                <p>Nikmati isi ulang air minum tanpa batas selama latihan.</p>
            </div>
        </div>

        <!-- Baris bawah (2 fasilitas) -->
        <div class="col-lg-6 col-md-6">
            <div class="feature-box">
                <h5><i class="bi bi-lock-fill icon-small"></i> Loker</h5>
                <p>Keamanan barang pribadi dengan loker eksklusif.</p>
            </div>
        </div>

        <div class="col-lg-6 col-md-6">
            <div class="feature-box">
                <h5><i class="bi bi-person-arms-up icon-small"></i> Ruang Shower</h5>
                <p>Fasilitas shower untuk menyegarkan diri setelah latihan.</p>
            </div>
        </div>
    </div>
</section>

{{-- <footer class="footer text-white py-4">
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
</footer> --}}@include('components.footer')


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

