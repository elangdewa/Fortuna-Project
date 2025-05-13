<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="{{ asset('css/Fitness.css') }}" rel="stylesheet">
   
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

</head>
<body>
    @include('layouts.navbar')

    <section class="bg-home">
        <div class="overlay">
            <div class="content">
                <h1>Kelas fitness untuk tubuh kuat dan bugar</h1>
                <p>
                    Rasakan pengalaman latihan terbaik dengan instruktur profesional, fasilitas modern, dan suasana yang mendukung. Dapatkan tubuh lebih sehat, kuat, dan bugar dengan kelas yang seru dan efektif!
                </p>
            </div>
        </div>
    </section>


<section class="classes-section">
    <div class="container">
        <div class="classes-header text-center">
            <h2 class="classes-title">JELAJAHI BERBAGAI KELAS YANG KAMU SUKA</h2>
            <div class="title-underline"></div>
        </div>

        <div class="classes-grid">
            <!-- Class Card: Zumba -->
            <div class="class-card" data-aos="fade-up" data-aos-delay="100">
                <div class="class-img-container">
                  <img src="{{ asset('images/zumba.jpg') }}" alt="Zumba">
                    <div class="class-overlay">
                        <div class="class-details">
                            <p>Gerak bersama dengan musik yang energik</p>

                        </div>
                    </div>
                </div>
                <div class="class-label">
                    <span>Zumba</span>
                    <div class="class-icon"><i class="bi bi-music-note-beamed"></i></div>
                </div>
            </div>

            <!-- Class Card: Dance Class -->
            <div class="class-card" data-aos="fade-up" data-aos-delay="200">
                <div class="class-img-container">
                    <img src="{{ asset('images/dance.jpg') }}" alt="Dance Class" >
                    <div class="class-overlay">
                        <div class="class-details">
                            <p>Ekspresikan diri dengan berbagai gerakan tari</p>

                        </div>
                    </div>
                </div>
                <div class="class-label">
                    <span>Dance Class</span>
                    <div class="class-icon"><i class="bi bi-soundwave"></i></div>
                </div>
            </div>

            <!-- Class Card: Poundfit -->
            <div class="class-card" data-aos="fade-up" data-aos-delay="300">
                <div class="class-img-container">
                    <img src="{{ asset('images/poundfit.jpg') }}" alt="Pound Fit" >
                    <div class="class-overlay">
                        <div class="class-details">
                            <p>Kombinasi kardio dan strength training dengan drumstick</p>

                        </div>
                    </div>
                </div>
                <div class="class-label">
                    <span>Poundfit</span>
                    <div class="class-icon"><i class="bi bi-lightning-charge"></i></div>
                </div>
            </div>

            <!-- Class Card: Aerobic -->
            <div class="class-card" data-aos="fade-up" data-aos-delay="400">
                <div class="class-img-container">
                     <img src="{{ asset('images/aerobic.jpg') }}" alt="Aerobic">
                    <div class="class-overlay">
                        <div class="class-details">
                            <p>Latihan kardio untuk meningkatkan stamina dan kebugaran</p>

                        </div>
                    </div>
                </div>
                <div class="class-label">
                    <span>Aerobic</span>
                    <div class="class-icon"><i class="bi bi-heart-pulse"></i></div>
                </div>
            </div>

            <!-- Class Card: Yoga -->
            <div class="class-card" data-aos="fade-up" data-aos-delay="100">
                <div class="class-img-container">
                      <img src="{{ asset('images/yoga.jpg') }}" alt="yoga" >
                    <div class="class-overlay">
                        <div class="class-details">
                            <p>Temukan keseimbangan dan fleksibilitas tubuh</p>

                        </div>
                    </div>
                </div>
                <div class="class-label">
                    <span>Yoga</span>
                    <div class="class-icon"><i class="bi bi-flower1"></i></div>
                </div>
            </div>

            <!-- Class Card: Trampoline -->
            <div class="class-card" data-aos="fade-up" data-aos-delay="200">
                <div class="class-img-container">
                   <img src="{{ asset('images/trampoline.jpg') }}" alt="Trampoline" >
                    <div class="class-overlay">
                        <div class="class-details">
                            <p>Latihan kardio yang menyenangkan dengan trampolin</p>

                        </div>
                    </div>
                </div>
                <div class="class-label">
                    <span>Trampoline</span>
                    <div class="class-icon"><i class="bi bi-arrows-move"></i></div>
                </div>
            </div>

            <!-- Class Card: Step Motion -->
            <div class="class-card" data-aos="fade-up" data-aos-delay="300">
                <div class="class-img-container">
                      <img src="{{ asset('images/stepmotion.jpg') }}" alt="Step Motion" >
                    <div class="class-overlay">
                        <div class="class-details">
                            <p>Latihan kardio berkualitas tinggi dengan platform step</p>

                        </div>
                    </div>
                </div>
                <div class="class-label">
                    <span>Step Motion</span>
                    <div class="class-icon"><i class="bi bi-skip-forward"></i></div>
                </div>
            </div>

            <!-- Class Card: Ladies Body Workout -->
            <div class="class-card" data-aos="fade-up" data-aos-delay="400">
                <div class="class-img-container">
                      <img src="{{ asset('images/ladieswork.jpg') }}" alt="Ladies Body Workout" >
                    <div class="class-overlay">
                        <div class="class-details">
                            <p>Program khusus untuk membentuk tubuh wanita</p>

                        </div>
                    </div>
                </div>
                <div class="class-label">
                    <span>Ladies Body Workout</span>
                    <div class="class-icon"><i class="bi bi-gender-female"></i></div>
                </div>
            </div>

            <!-- Class Card: Fortuna Fight -->
            <div class="class-card" data-aos="fade-up" data-aos-delay="500">
                <div class="class-img-container">
                    <img src="{{ asset('images/fight.jpg') }}" alt="Fortuna Fight" >
                    <div class="class-overlay">
                        <div class="class-details">
                            <p>Latihan intensif dengan kombinasi gerakan bela diri</p>

                        </div>
                    </div>
                </div>
                <div class="class-label">
                    <span>Fortuna Fight</span>
                    <div class="class-icon"><i class="bi bi-shield"></i></div>
                </div>
            </div>
        </div>


    </div>
</section>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    });
</script>



@include('layouts.footer')


</body>
<script>
    document.getElementById("menuToggle").addEventListener("click", function() {
        document.getElementById("mobileMenu").classList.toggle("active");
    });
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>
