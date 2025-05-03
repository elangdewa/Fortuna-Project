<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>

    @vite(['resources/css/Fitness.css', 'resources/js/app.js'])
    {{-- <link href="{{ asset('css/Fitness.css') }}" rel="stylesheet"> --}}
    <!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<script>
    document.getElementById("menuToggle").addEventListener("click", function() {
        document.getElementById("mobileMenu").classList.toggle("active");
    });
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
    @include('components.navbar')

    @vite('resources/js/app.js')
</body>
</html>
