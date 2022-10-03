<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- AlpineJS -->
        <script defer src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js"></script>
        <!-- App CSS -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- AlpineJS -->
        <script defer src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js"></script>
        <!-- Boxicons CSS -->
        <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
        <!-- Swiper JS -->
        <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
        <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
        <title>{{ env('APP_NAME') }} @isset($title) | {{ $title }}@endisset</title>
    </head>

    <body>
        <main class="min-h-screen bg-center bg-fixed bg-cover"
            style="background-image: url('{{asset('images/grid.svg')}}');">
            {{ $slot }}
        </main>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/script.js') }}"></script>
    </body>

</html>
