<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tarifario - Login</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-[#0b0624] min-h-screen text-white font-sans flex flex-col">

<!-- Cabecera -->
<header class="flex justify-between items-center px-8 py-5 shadow-md">
    <!-- Logo -->
    <div class="flex items-center space-x-3">
        <img src="https://cdn.bio.link/uploads/profile_pictures/2023-08-14/zy6w2dBKfntNXUTkxjpdOTuEgWHMmo2Q.png"
             alt="Logo" style="width: 70px; height: auto;">
        <span class="text-white text-xl font-bold">Tarifario</span>
    </div>

    <!-- Menú de navegación -->
    <nav class="space-x-8 text-lg">
        <a href="{{ route('login') }}" class="px-5 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-full transition">
            Login
        </a>
    </nav>
</header>

<!-- Contenido principal centrado -->
<main class="flex-1 flex items-center justify-center text-center px-4">
    <div class="max-w-xl">
        <p class="text-lg text-gray-800 leading-relaxed mb-8">
            Este es un sistema tarifario moderno que permite gestionar de forma eficiente los diferentes trámites y costos asociados dentro de la Universidad Peruana Unión.
        </p>
    </div>
</main>

</body>
</html>
