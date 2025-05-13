<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Fortuna Fitness & Cafe</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="{{ asset('css/about.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    @include('layouts.navbar')

    <section class="bg-home">
        <div class="overlay">
            <div class="content">
                <h1>Tentang Fortuna Fitness</h1>
                <p>
                   Fortuna Fitness hadir sebagai ruang kebugaran modern yang mengedepankan kualitas, kenyamanan, dan hasil nyata. Kami percaya bahwa kebugaran bukan hanya soal tubuh yang kuat, tetapi juga tentang gaya hidup yang seimbang dan sehat.
                </p>
            </div>
        </div>
    </section>

    <section class="featured-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="card feature-card">
                        <div class="card-body">
                            <h2 class="feature-title"> <span class="text-orange">Gerak</span> untuk Semua, <span class="text-orange">Sehat</span> untuk Selamanya</h2>
                            <p class="feature-text">
                                Fortuna Fitness and Cafe adalah tempat di mana gaya hidup sehat dimulai dan dinikmati Mulai harimu dengan sesi latihan yang menyegarkan. Baik itu gym, kelas kebugaran, atau personal training dan lanjutkan dengan bersantai di cafe kami yang nyaman.
                            </p>
                            <p class="feature-text">
                                Kami percaya bahwa kesehatan bukan hanya soal keringat, tapi juga soal keseimbangan. Di sini, kamu bisa berolahraga tanpa tekanan, lalu menikmati makanan dan minuman bergizi yang dibuat untuk mendukung gaya hidup aktifmu.
                            </p>
                            <p class="feature-text">
                                Tempat yang pas untuk bergerak, bersosialisasi, dan recharge semua dalam satu lokasi.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="feature-images">
                        <img src="{{ asset('images/about1.jpg') }}" alt="Fitness Group 1" class="feature-img top">
                        <img src="{{ asset('images/about2.jpg') }}" alt="Fitness Group 2" class="feature-img bottom">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="location-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="ratio ratio-4x3">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.982539999559!2d112.74461977367709!3d-7.355852992653086!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e50008c8f04b%3A0xd9f8ea0bcf6d85b8!2sFORTUNA%20FITNESS%20%26%20CAFE!5e0!3m2!1sid!2sid!4v1746887245483!5m2!1sid!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="location-text">
                        <h2>Lokasi Kami</h2>
                        <p>Datang dan kunjungi FORTUNA FITNESS & CAFE di Sidoarjo. Kami menyediakan fasilitas lengkap dan suasana yang nyaman untuk menunjang gaya hidup sehat Anda.</p>
                        <p><strong>Alamat:</strong> Jl. Belahan Wedoro No.10, Waru, Sidoarjo.</p>
                        <p><strong>Jam Buka:</strong> 06.00 - 22.00 WIB</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="gallery-section">
        <div class="container">
            <div class="section-header text-center">
                <h2>Galeri</h2>
                <p>Lihat berbagai momen terbaik di Fortuna Fitness & Cafe.</p>
            </div>

            <div class="swiper gallery-swiper">
                <div class="swiper-wrapper">
                    <!-- Slide Items -->
                    <div class="swiper-slide">
                        <div class="gallery-item">
                            <img src="{{ asset('images/about.jpg') }}" alt="Gallery 1" class="gallery-img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="gallery-item">
                            <img src="{{ asset('images/Home.jpg') }}" alt="Gallery 2" class="gallery-img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="gallery-item">
                            <img src="{{ asset('images/about1.jpg') }}" alt="Gallery 3" class="gallery-img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="gallery-item">
                            <img src="{{ asset('images/about2.jpg') }}" alt="Gallery 4" class="gallery-img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="gallery-item">
                            <img src="{{ asset('images/galeri1.jpg') }}" alt="Gallery 5" class="gallery-img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="gallery-item">
                            <img src="{{ asset('images/galeri2.jpg') }}" alt="Gallery 6" class="gallery-img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="gallery-item">
                            <img src="{{ asset('images/Home.jpg') }}" alt="Gallery 7" class="gallery-img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="gallery-item">
                            <img src="{{ asset('images/galeri4.jpg') }}" alt="Gallery 8" class="gallery-img">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="gallery-item">
                            <img src="{{ asset('images/galeri3.jpg') }}" alt="Gallery 9" class="gallery-img">
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    @include('layouts.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @vite('resources/js/app.js')

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Mobile menu toggle
        let menu = document.getElementById("mobileMenu");
        let toggleButton = document.getElementById("menuToggle");

        if (menu && toggleButton) {
            toggleButton.addEventListener("click", function(event) {
                event.stopPropagation();
                menu.classList.toggle("active");
            });

            document.addEventListener("click", function(event) {
                if (!menu.contains(event.target) && !toggleButton.contains(event.target)) {
                    menu.classList.remove("active");
                }
            });
        }

         const gallerySwiper = new Swiper('.gallery-swiper', {
        loop: true,
        spaceBetween: 20,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {

            1200: {
                slidesPerView: 3,
            },

            768: {
                slidesPerView: 2,
            },

            0: {
                slidesPerView: 1,
            }
        }
    });
});
    </script>
</body>
</html>
