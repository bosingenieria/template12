<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Acceso Denegado</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Estilos para las partículas */
        .particle {
            position: absolute;
            background: white;
            border-radius: 50%;
            opacity: 0.6;
            animation: float ease-in-out infinite;
        }

        /* Animación para las partículas */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0) translateX(0);
            }

            50% {
                transform: translateY(-20px) translateX(20px);
            }
        }

        /* Animación para el texto 404 */
        @keyframes float-text {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* Aplicar la animación al texto 404 */
        .floating-text {
            animation: float-text 3s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-white flex items-center justify-center h-screen overflow-hidden">

    <!-- Contenedor de partículas -->
    <div id="particles-container" class="absolute w-full h-full"></div>

    <div class="text-center relative z-10">
        <!-- Número 404 en 3D con efecto flotante -->
        <h1 class="text-8xl font-extrabold relative inline-block">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-purple-600 floating-text">404</span>
            <span class="absolute top-2 left-2 text-gray-400 dark:text-gray-700 opacity-40 floating-text">404</span>
        </h1>

        <!-- Mensaje de error -->
        <p class="text-2xl mt-4 font-semibold">¡Recurso no encontrado!</p>
        <p class="text-gray-500 dark:text-gray-400 mt-2 max-w-md mx-auto">
            No se encuentra el recurso. Contacta con el administrador si crees que esto es un error.
        </p>

        <!-- Botón para volver -->
        <a href="{{ route('dashboard') }}"
            class="mt-6 inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition-transform transform hover:scale-105">
            Volver al inicio
        </a>
    </div>

    <script>
        // Función para crear partículas
        function createParticles() {
            const container = document.getElementById('particles-container');
            const numParticles = 50; // Número de partículas

            for (let i = 0; i < numParticles; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');

                // Tamaño y posición aleatorios
                const size = Math.random() * 5 + 2; // Tamaño entre 2px y 7px
                const x = Math.random() * window.innerWidth;
                const y = Math.random() * window.innerHeight;
                const duration = Math.random() * 10 + 5; // Duración de la animación entre 5s y 15s

                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.left = `${x}px`;
                particle.style.top = `${y}px`;
                particle.style.animationDuration = `${duration}s`;

                container.appendChild(particle);
            }
        }

        // Crear partículas al cargar la página
        createParticles();
    </script>

</body>

</html>