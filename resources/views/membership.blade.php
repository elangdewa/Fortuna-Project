<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="{{ asset('css/membership.css') }}" rel="stylesheet">
    <!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

</head>
<body>
    @include('layouts.navbar')

    <section class="bg-home-redesigned">
    <div class="overlay-gradient">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Pilih Membership<br><span class="highlight">untuk Gaya Hidup Sehatmu</span></h1>
                <p class="hero-description">
                  Temukan berbagai pilihan paket keanggotaan yang dirancang untuk mendukung perjalanan kebugaran Anda. Mulailah langkah pertama menuju hidup yang lebih sehat dan berkualitas bersama kami.
                </p>
                </div>
            </div>
        </div>
    </div>
</section>


    <section class="pricing-section">
        <div class="container">
            <div class="pricing-header">
                <h2 class="pricing-title">MEMBERSHIP PRICELIST</h2>
                <div class="title-underline"></div>
                <div class="opening-hours">
                    <i class="bi bi-clock"></i> BUKA SETIAP HARI JAM 6 PAGI - 10 MALAM
                </div>
            </div>

            <!-- Daily Price Section -->
            <div class="daily-price-section">
                <div class="corner-decoration top-left"></div>
                <div class="daily-price-tag">
                    <h3>INSIDENTIL / DAILY</h3>
                    <div class="price">IDR 85.000</div>
                </div>
                <div class="corner-decoration bottom-right"></div>
            </div>

            <!-- Membership Price Grid -->
            <div class="pricing-grid">
                <!-- 1 Month -->
                <div class="price-card">
                    <div class="price-header">
                        <h3 class="price-duration">1 MONTH</h3>
                    </div>
                    <div class="price-body">
                        <div>
                            <div class="price-amount">IDR 450.000</div>
                            <ul class="price-features">
                                <li>Access to all gym equipment</li>
                                <li>Free WiFi</li>
                                <li>Free refill water</li>
                                <li>Lockers and shower room</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- 3 Months -->
                <div class="price-card">
                    <div class="price-header">
                        <h3 class="price-duration">3 MONTHS</h3>
                    </div>
                    <div class="price-body">
                        <div>
                            <div class="price-amount">IDR 1.155.000</div>
                            <div class="price-per-month">(IDR 385.000 / MONTH)</div>
                            <ul class="price-features">
                                <li>Access to all gym equipment</li>
                                <li>Free WiFi</li>
                                <li>Free refill water</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- 6 Months -->
                <div class="price-card">
                    <div class="price-header">
                        <h3 class="price-duration">6 MONTHS</h3>
                    </div>
                    <div class="price-body">
                        <div>
                            <div class="price-amount">IDR 1.950.000</div>
                            <div class="price-per-month">(IDR 325.000 / MONTH)</div>
                            <ul class="price-features">
                                <li>Access to all gym equipment</li>
                                <li>Free WiFi</li>
                                <li>Free refill water</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- 12 Months -->
                <div class="price-card">
                    <div class="price-header">
                        <h3 class="price-duration">12 MONTHS</h3>
                    </div>
                    <div class="price-body">
                        <div>
                            <div class="price-amount">IDR 3.300.000</div>
                            <div class="price-per-month">(IDR 275.000 / MONTH)</div>
                            <ul class="price-features">
                                <li><strong>FREE 1 MONTH MEMBERSHIP</strong></li>
                                <li>Access to all gym equipment</li>
                                <li>Free WiFi</li>
                                <li>Free refill water</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PT Section -->
            <div class="pt-section">
                <h3 class="pt-title">PRIVAT PERSONAL TRAINER</h3>
                <div class="pt-price">IDR 2.000.000</div>
                <div class="pt-sessions">FOR 10 SESSION</div>
            </div>

            <!-- Benefits & Services Section -->
            <div class="benefits-section">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="benefits-title">
                            <i class="bi bi-gift"></i> BENEFIT
                        </h3>
                        <ul class="benefits-list">
                            <li>FREE WIFI</li>
                            <li>FREE REFILL WATER</li>
                            <li>FREE 3 DAYS TRIAL</li>
                            <li>LOCKERS AND SHOWER ROOM</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h3 class="services-title">
                            <i class="bi bi-clipboard-check"></i> OUR SERVICES
                        </h3>
                        <ul class="services-list">
                            <li>FITNESS PROGRAM</li>
                            <li>CARDIO EXERCISES</li>
                            <li>PERSONAL TRAINING</li>
                            <li>COMPLETE EQUIPMENT STUDIO CLASS</li>
                            <li>AND CAFE</li>
                        </ul>
                    </div>
                </div>
            </div>



            <!-- Arrow Decoration -->
            <div class="arrow-decoration">
                <i class="bi bi-arrow-up-right"></i>
            </div>
        </div>
    </section>

@include('layouts.footer')

    @vite('resources/js/app.js')
</body>
<script>
    document.getElementById("menuToggle").addEventListener("click", function() {
        document.getElementById("mobileMenu").classList.toggle("active");
    });
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>
