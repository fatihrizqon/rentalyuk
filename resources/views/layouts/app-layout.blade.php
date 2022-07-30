<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- AlpineJS -->
        <script defer src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js"></script>
        <!-- App CSS -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- Boxicons CSS -->
        <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
        <!-- Swiper JS -->
        <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
        <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
        <!-- Animate Style -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        <title>{{ env('APP_NAME') }} @isset($title) | {{ $title }}@endisset</title>
    </head>

    <body>
        <header class="absolute flex w-full top-0 left-0 z-10">
            <!-- Separate for Authenticated User -->
            <div id="header" class="absolute w-full ">
                @include('layouts.navigation')
            </div>
        </header>

        <main class="bg-redruby">
            {{ $slot }}
        </main>

        <!-- Alerts -->
        <div class="relative flex justify-center">
            <div class="fixed bottom-0">
                @if(Session::get('status'))
                <x-success-alert></x-success-alert>
                @endif
                @if(Session::get('info'))
                <x-info-alert></x-info-alert>
                @endif
                @if(Session::get('warning'))
                <x-warning-alert></x-warning-alert>
                @endif
                @if(Session::get('danger'))
                <x-danger-alert></x-danger-alert>
                @endif
            </div>
        </div>

        <footer id="footer" class="grid min-h-[50vh] text-white bg-gradient-to-t from-redfire to-redruby">
            <div class="flex flex-col lg:flex-row items-start py-4 justify-between container w-full">
                <div class="flex flex-col items-start w-full p-2 lg:p-0 text-white font-normal gap-3">
                    <span class="flex items-center space-x-3">
                        <i class="bx bxs-car-garage bx-sm"> </i>
                        <h1 class="flex">Daerah Istimewa Yogyakarta</h1>
                    </span>
                    <span class="flex items-center space-x-3"><i class="bx bx-phone-call bx-sm"> </i>
                        <h1 class="flex">082145556225</h1>
                    </span>
                    <span class="flex items-center space-x-3"><i class="bx bxl-gmail bx-sm"> </i>
                        <h1 class="flex">contact@rentalyuk.id</h1>
                    </span>
                </div>
                <div class="flex flex-col items-center w-full p-2 lg:p-0 text-white font-normal gap-3">
                    <div class="flex flex-col w-full gap-2">
                        <span class="text-center text-lg font-light">Latest News & Promo Subsciption</span>
                        <form class="grid gap-y-4" action="">
                            @csrf
                            <div class="grid gap-y-2">
                                <input class="p-2" type="email" name="subsciption" id="subsciption"
                                    placeholder="Enter your email" required>
                                @error('email')
                                <span class=" font-medium text-sm text-redfire">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="btn border text-white">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="flex flex-col items-end w-full p-2 lg:p-0 text-white font-normal gap-3">
                    <a href="{{ route('/') }}#home">Home</a>
                    <a href="{{ route('/') }}#about">About Us</a>
                    <a href="{{ route('booking') }}">Booking</a>
                    @guest
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                    @else
                    <a href="{{ route('account') }}">Account Settings</a>
                    @endguest
                </div>
            </div>

            <div class="self-end w-full py-8">
                <div class="mb-2 flex items-center justify-center">
                    <a href="https://www.instagram.com/fatihrizqon"
                        class="mr-3 flex h-9 w-9 cursor-pointer items-center justify-center rounded-full border border-light text-white hover:text-redfire hover:bg-white transition duration-300"
                        target="_blank"><i class="bx bxl-instagram bx-sm"></i>
                    </a>
                    <a href="https://www.twitter.com/fatihrizqon"
                        class="mr-3 flex h-9 w-9 cursor-pointer items-center justify-center rounded-full border border-light text-white hover:text-redfire hover:bg-white transition duration-300"
                        target="_blank"><i class="bx bxl-twitter bx-sm"></i>
                    </a>
                    <a href="mailto: fatihrizqon@gmail.com"
                        class="mr-3 flex h-9 w-9 cursor-pointer items-center justify-center rounded-full border border-light text-white hover:text-redfire hover:bg-white transition duration-300"
                        target="_blank"><i class="bx bxl-gmail bx-sm"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/fatihrizqon/"
                        class="hover:bg-darwhitek mr-3 flex h-9 w-9 cursor-pointer items-center justify-center rounded-full border border-light text-white hover:text-redfire hover:bg-white transition duration-300"
                        target="_blank"><i class="bx bxl-linkedin-square bx-sm"></i>
                    </a>
                    <a href="https://www.github.com/fatihrizqon"
                        class="mr-3 flex h-9 w-9 cursor-pointer items-center justify-center rounded-full border border-light text-white hover:text-redfire hover:bg-white transition duration-300"
                        target="_blank"><i class="bx bxl-github bx-sm"></i>
                    </a>
                </div>
                <div class="flex items-center justify-center text-center text-xs font-normal text-white">
                    <span class="mr-1"><a href="https://www.instagram.com/fatihrizqon/"
                            class="transition duration-300 hover:text-slate-200" target="_blank">Muhammad Fatih
                            Rizqon </a> (2022) |
                        Created by using</span>
                    <a href="https://tailwindcss.com/" target="_blank"><i class="bx bxl-tailwind-css bx-sm"
                            style="color: #38bdf8"></i></a>
                </div>
            </div>
        </footer>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/script.js') }}"></script>
    </body>

</html>
