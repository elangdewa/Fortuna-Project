<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Homepage</title>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>
<body>
    @include('layouts.navbar')
   <section class="bg-home">
    <div class="overlay">
        <div class="animated-content">
            <div class="tagline">FORTUNA FITNESS</div>
            <h1 class="animated-title">Bergerak lebih baik, <br><span class="highlight">hidup lebih berkualitas.</span></h1>
            <p class="animated-text">
                Dengan kelas kebugaran bintang lima, peralatan canggih, dan staf yang ramah,
                setiap kunjungan akan menjadi pengalaman yang menyenangkan dan menginspirasi.
            </p>
        </div>
    </div>
</section>

<section class="bg-half-black">
    <div class="split-section">
        <!-- Left Half - Full Image -->
        <div class="image-half">
            <img src="{{ asset('images/section2.jpg') }}" alt="Fortuna Gym">
        </div>

        <!-- Right Half - Content -->
        <div class="content-half">
            <h2 class="highlighted-text">MENGAPA FORTUNA FITNESS <br> PILIHAN TERBAIK</h2>
            <p>
                Fortuna Fitness menawarkan pengalaman olahraga terbaik dengan fasilitas modern, kelas beragam, dan komunitas suportif.
                Dengan akses ke semua cabang, jadwal fleksibel, serta instruktur profesional, Anda bisa mencapai target kebugaran dengan efektif.
                Lebih dari sekadar gym, Fortuna Fitness adalah gaya hidup sehat yang berkelanjutan.
            </p>
        </div>
    </div>
</section>


<!-- Enhanced Membership Section -->
<!-- Enhanced Membership Section -->
<section class="membership-section">
    <div class="container">
        <!-- Section Header -->
        <div class="membership-header text-center">
            <h2 class="membership-title">Membership Mulai Dari <span class="price-highlight">300.000/Bulan</span></h2>
            <p class="membership-subtitle">
                Nikmati kebebasan berolahraga di Fortuna Fitness dengan fasilitas premium dan akses kelas sepuasnya!
            </p>
        </div>

        <!-- Membership Cards -->
        <div class="row justify-content-center">
            <!-- Card 1: Kelas -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="membership-card floating">
                    <span class="membership-badge">Populer</span>
                    <div class="card-img-container">
                        <img src="images/fitness.jpg" alt="Kelas Fitness">
                        <div class="card-overlay"></div>
                    </div>
                    <div class="card-body">
                        <div class="card-icon">
                            <i class="bi bi-activity" style="color: white; font-size: 24px;"></i>
                        </div>
                        <h3 class="card-title">Berbagai Macam Kelas</h3>
                        <p class="card-text">Variasi kelas yang dirancang untuk semua level kebugaran untuk membantu Anda mencapai tujuan fitness Anda.</p>
                        <ul class="feature-list">
                            <li>Zumba</li>
                            <li>Pound Fit</li>
                            <li>Yoga</li>
                            <li>HIIT</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Card 2: Personal Trainer -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="membership-card">
                    <div class="card-img-container">
                        <img src="images/PT.jpg" alt="Personal Trainer">
                        <div class="card-overlay"></div>
                    </div>
                    <div class="card-body">
                        <div class="card-icon">
                            <i class="bi bi-person-check" style="color: white; font-size: 24px;"></i>
                        </div>
                        <h3 class="card-title">Personal Trainer</h3>
                        <p class="card-text">Pelatih profesional kami akan membantu Anda mencapai tujuan dengan program yang dipersonalisasi.</p>
                        <ul class="feature-list">
                            <li>Pelatih bersertifikasi</li>
                            <li>Program khusus</li>
                            <li>Pemantauan progres</li>
                            <li>Konsultasi nutrisi</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Card 3: Komunitas -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="membership-card floating">
                    <div class="card-img-container">
                        <img src="images/Komunitas.jpg" alt="Komunitas">
                        <div class="card-overlay"></div>
                    </div>
                    <div class="card-body">
                        <div class="card-icon">
                            <i class="bi bi-people" style="color: white; font-size: 24px;"></i>
                        </div>
                        <h3 class="card-title">Komunitas Supportif</h3>
                        <p class="card-text">Bergabung dengan komunitas yang peduli dengan kesehatan dan selalu saling mendukung satu sama lain.</p>
                        <ul class="feature-list">
                            <li>Event komunitas</li>
                            <li>Tantangan bulanan</li>
                            <li>Group workout</li>
                            <li>Dukungan motivasi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action Button -->
        <div class="membership-btn-container">
          <a href="/membership" class="membership-btn">
                <i class="bi bi-arrow-right" style="margin-right: 8px;"></i>
                Lihat Semua Paket Membership
            </a>
        </div>
    </div>
</section>






<section class="container my-5">
    <h2 class="facility-title text-center mb-5">Fasilitas Eksklusif Untuk Pengalaman Terbaik!</h2>


    <div class="row g-4 justify-content-center">
        <div class="col-lg-4 col-md-6">
            <div class="feature-box">
                <div class="feature-icon"><i class="bi bi-hdd-stack"></i></div>
                <h3>Peralatan Premium</h3>
                <p>Akses ke peralatan fitness terbaik dan modern.</p>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="feature-box">
                <div class="feature-icon"><i class="bi bi-people-fill"></i></div>
                <h3>Pelatih Profesional</h3>
                <p>Pelatih bersertifikasi untuk membimbing perjalanan fitness Anda.</p>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="feature-box">
                <div class="feature-icon"><i class="bi bi-droplet-fill"></i></div>
                <h3>Isi Ulang Air Gratis</h3>
                <p>Nikmati isi ulang air minum tanpa batas selama latihan.</p>
            </div>
        </div>
    </div>

    <!-- Baris Kedua (2 Card) -->
    <div class="row g-4 justify-content-center mt-1">
        <div class="col-lg-4 col-md-6">
            <div class="feature-box">
                <div class="feature-icon"><i class="bi bi-lock-fill"></i></div>
                <h3>Loker</h3>
                <p>Keamanan barang pribadi dengan loker eksklusif.</p>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="feature-box">
                <div class="feature-icon"><i class="bi bi-person-arms-up"></i></div>
                <h3>Ruang Shower</h3>
                <p>Fasilitas shower untuk menyegarkan diri setelah latihan.</p>
            </div>
        </div>
    </div>
</section>



@include('layouts.footer')

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

