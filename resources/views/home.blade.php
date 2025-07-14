<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <meta name="theme-color" content="#6777ef" />
    <link rel="apple-touch-icon" href="{{ asset('logo.webp') }}">
    <link rel="preload" as="image" href="/img/logo.webp" />

    {{-- <link rel="manifest" href="{{ asset('/manifest.json') }}"> --}}
    <title>PosSys</title>

    {{-- <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">       
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" /> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        .loader {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: inline-block;
            position: relative;
            border: 3px solid;
            border-color: #FFF #FFF transparent transparent;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
        }

        .loader::after,
        .loader::before {
            content: '';
            box-sizing: border-box;
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            margin: auto;
            border: 3px solid;
            border-color: transparent transparent #13deb9 #13deb9;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            box-sizing: border-box;
            animation: rotationBack 0.5s linear infinite;
            transform-origin: center center;
        }

        .loader::before {
            width: 32px;
            height: 32px;
            border-color: #FFF #FFF transparent transparent;
            animation: rotation 1.5s linear infinite;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes rotationBack {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(-360deg);
            }
        }
    </style>
    @vite('resources/css/app.css')
</head>

<body>
    <div id="loader"
        style="position: fixed; width: 100%; height: 100%; background: #192a67; display: flex; justify-content: center; align-items: center; z-index: 9999;">
        <span class="loader"></span>
    </div>
    <div id="app">
        <admin></admin>
    </div>
    @vite('resources/js/app.js')
    <script>
        // Marca el tiempo de inicio
        const loaderStart = Date.now();

        window.addEventListener('load', () => {
            const loader = document.getElementById('loader');
            const app = document.getElementById('app');

            // Calcula cuánto tiempo pasó desde que se mostró el loader
            const elapsedTime = Date.now() - loaderStart;
            const minimumTime = 2000; // 2 segundos

            // Si el tiempo transcurrido es menor al mínimo, espera el resto
            if (elapsedTime < minimumTime) {
                setTimeout(() => {
                    loader.style.display = 'none';
                    app.style.display = 'block';
                }, minimumTime - elapsedTime);
            } else {
                loader.style.display = 'none';
                app.style.display = 'block';
            }
        });
    </script>
</body>

</html>