<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="{{ asset('css/Fitness.css') }}" rel="stylesheet">
    <!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

</head>
<body>
    @include('components.navbar')

    <section class="bg-home">
        <div class="overlay">
            <div class="content">
                <h1>Kelas fitness untuk tubuh kuat dan bugar.</h1>
                <p>
                    Rasakan pengalaman latihan terbaik dengan instruktur profesional, fasilitas modern, dan suasana yang mendukung. Dapatkan tubuh lebih sehat, kuat, dan bugar dengan kelas yang seru dan efektif!
                </p>
            </div>
        </div>
    </section>
@include('components.footer')

    @vite('resources/js/app.js')
</body>
<script>
    document.getElementById("menuToggle").addEventListener("click", function() {
        document.getElementById("mobileMenu").classList.toggle("active");
    });
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>
