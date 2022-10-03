<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- App CSS -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <!-- AlpineJS -->
        <script defer src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js"></script>
        <!-- Boxicons CSS -->
        <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
        <!-- Swiper JS -->
        <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
        <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
        <!-- Chart JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"
            integrity="sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <title>{{ env('APP_NAME') }} Admin Panel @isset($title) | {{ $title }}@endisset</title>
    </head>

    <body>
        <header class="flex w-full top-0 left-0 shadow-md bg-redfire">
            <div x-data="{ navigation : true }" class="flex w-full items-center justify-between py-3 text-white">
                <ul class="flex flex-wrap justify-between items-center w-[90%] mx-auto">
                    <li class="group flex items-center gap-2">
                        <a class="pacifico font-medium text-xl hover:text-gray-300"
                            href="{{ route('/') }}#home">{{ env('APP_NAME') }}</a>
                    </li>

                    <li x-data="{ account : false }" class=" flex flex-row select-none" x-show="navigation"
                        @scroll.window.throttle="account = false" x-transition>
                        <ul class="relative">
                            <li class="flex flex-row items-center justify-between px-2">
                                <button @click="account = !account" type="button"
                                    class="navlink inline-flex justify-start items-center text-base font-light"
                                    aria-expanded="true" aria-haspopup="true">
                                    {{ Auth::user()->username }}
                                    <i class='bx bx-chevron-down bx-sm'></i>
                                </button>
                            </li>

                            <li id="account" x-show="account" x-transition @click.outside="account = false"
                                class="hidden absolute right-0 mt-2 font-light">
                                <ul class="flex flex-col w-60 gap-2 bg-white text-redruby rounded-lg p-2 shadow-md">
                                    <li>
                                        <a class="px-2 hover:text-gray-600 font-medium"
                                            href="{{ route('/') }}#home">Home</a>
                                    </li>
                                    <li>
                                        <a class="px-2 hover:text-gray-600 font-medium"
                                            href="{{ route('/') }}#about">About</a>
                                    </li>
                                    <li>
                                        <a class="px-2 hover:text-gray-600 font-medium"
                                            href="{{ route('/') }}#footer">Contact</a>
                                    </li>
                                    <li>
                                        <a class="px-2 hover:text-gray-600 font-medium"
                                            href="{{ route('booking') }}">Booking</a>
                                    </li>
                                    <hr>
                                    <li>
                                        <a href="{{ route('account') }}"
                                            class="px-2 hover:text-gray-600 font-medium">Account
                                            Settings</a>
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="px-2 hover:text-gray-600 font-medium">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </header>

        <main class="flex flex-row min-h-screen bg-center bg-fixed bg-cover overflow-x-hidden"
            style="background-image: url('{{asset('images/grid.svg')}}');">
            <section id="sidenav" x-data="{ sidenav : false }"
                class="flex flex-col min-h-full bg-blacksmoky/50 shadow-lg">
                <ul class="flex flex-col px-4 gap-y-4 select-none">
                    <li
                        class="hidden lg:block hover:text-redfire py-4 transition duration-150 select-none cursor-pointer text-white">
                        <button @click="sidenav = !sidenav" x-show="sidenav" id="shrink"
                            class="flex font-light text-sm items-center gap-4" href="{{ route('admin') }}">
                            <i class='bx bx-chevron-left text-xl'></i>
                        </button>
                        <button @click="sidenav = !sidenav" x-show="!sidenav" id="expand"
                            class="flex font-light text-sm items-center gap-4" href="{{ route('admin') }}">
                            <i class='bx bx-chevron-right text-xl'></i>
                        </button>
                    </li>

                    <li class="sidenav-list hover:text-redfire py-4 transition duration-150 select-none cursor-pointer">
                        <a class="sidenav-link font-light flex text-sm items-center gap-4" href="{{ route('admin') }}">
                            <i class='bx bxs-dashboard text-xl'></i>
                            <span x-show="sidenav" x-transition @click.outside="sidenav = false"
                                @scroll.window.throttle="sidenav = false" class="sidenav-link pr-16">Dashboard</span>
                        </a>
                    </li>
                    <li class="sidenav-list hover:text-redfire py-4 transition duration-150 select-none cursor-pointer">
                        <a class="sidenav-link font-light flex text-sm items-center gap-4"
                            href="{{ route('bookings') }}">
                            <i class='bx bx-receipt text-xl'></i>
                            <span x-show="sidenav" x-transition @click.outside="sidenav = false"
                                @scroll.window.throttle="sidenav = false" class="sidenav-link pr-16">Bookings</span>
                        </a>
                    </li>
                    <li class="sidenav-list hover:text-redfire py-4 transition duration-150 select-none cursor-pointer">
                        <a class="sidenav-link font-light flex text-sm items-center gap-4"
                            href="{{ route('cashflows') }}">
                            <i class='bx bx-recycle text-xl'></i>
                            <span x-show="sidenav" x-transition @click.outside="sidenav = false"
                                @scroll.window.throttle="sidenav = false" class="sidenav-link pr-16">Cashflow</span>
                        </a>
                    </li>
                    <li class="sidenav-list hover:text-redfire py-4 transition duration-150 select-none cursor-pointer">
                        <a class="sidenav-link font-light flex text-sm items-center gap-4"
                            href="{{ route('categories') }}">
                            <i class='bx bx-category-alt text-xl'></i>
                            <span x-show="sidenav" x-transition @click.outside="sidenav = false"
                                @scroll.window.throttle="sidenav = false" class="sidenav-link pr-16">Categories</span>
                        </a>
                    </li>
                    <li class="sidenav-list hover:text-redfire py-4 transition duration-150 select-none cursor-pointer">
                        <a class="sidenav-link font-light flex text-sm items-center gap-4"
                            href="{{ route('vehicles') }}">
                            <i class='bx bx-car text-xl'></i>
                            <span x-show="sidenav" x-transition @click.outside="sidenav = false"
                                @scroll.window.throttle="sidenav = false" class="sidenav-link pr-16">Vehicles</span>
                        </a>
                    </li>
                    <li class="sidenav-list hover:text-redfire py-4 transition duration-150 select-none cursor-pointer">
                        <a class="sidenav-link font-light flex text-sm items-center gap-4" href="{{ route('users') }}">
                            <i class='bx bxs-user-account text-xl'></i>
                            <span x-show="sidenav" x-transition @click.outside="sidenav = false"
                                @scroll.window.throttle="sidenav = false" class="sidenav-link pr-16">Users</span>
                        </a>
                    </li>
                </ul>
            </section>
            <section id="wrapper" class="flex flex-col w-full min-h-screen overflow-hidden">
                {{ $slot }}
            </section>
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

        <footer id="footer" class="bottom-0 left-0 grid text-white bg-gradient-to-t from-redfire to-redruby">
            <div class="self-end w-full py-4">
                <div class="mb-2 flex items-center justify-center">
                    <a href="https://www.instagram.com/fatihrizqon"
                        class="mr-3 flex h-9 w-9 cursor-pointer items-center justify-center rounded-full border border-light text-white hover:text-redfire hover:bg-white transition duration-300"
                        target="_blank"><i class="bx bxl-instagram bx-xs"></i>
                    </a>
                    <a href="https://www.twitter.com/fatihrizqon"
                        class="mr-3 flex h-9 w-9 cursor-pointer items-center justify-center rounded-full border border-light text-white hover:text-redfire hover:bg-white transition duration-300"
                        target="_blank"><i class="bx bxl-twitter bx-xs"></i>
                    </a>
                    <a href="mailto: fatihrizqon@gmail.com"
                        class="mr-3 flex h-9 w-9 cursor-pointer items-center justify-center rounded-full border border-light text-white hover:text-redfire hover:bg-white transition duration-300"
                        target="_blank"><i class="bx bxl-gmail bx-xs"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/fatihrizqon/"
                        class="hover:bg-darwhitek mr-3 flex h-9 w-9 cursor-pointer items-center justify-center rounded-full border border-light text-white hover:text-redfire hover:bg-white transition duration-300"
                        target="_blank"><i class="bx bxl-linkedin-square bx-xs"></i>
                    </a>
                    <a href="https://www.github.com/fatihrizqon"
                        class="mr-3 flex h-9 w-9 cursor-pointer items-center justify-center rounded-full border border-light text-white hover:text-redfire hover:bg-white transition duration-300"
                        target="_blank"><i class="bx bxl-github bx-xs"></i>
                    </a>
                </div>
                <div class="flex items-center justify-center text-center text-xs font-normal text-white">
                    <span class="mr-1"><a href="https://www.instagram.com/fatihrizqon/"
                            class="transition duration-300 hover:text-slate-200" target="_blank">Muhammad Fatih
                            Rizqon </a> (2022) | </span>
                    <a href="https://tailwindcss.com/" target="_blank"><i class="bx bxl-tailwind-css bx-sm"
                            style="color: #38bdf8"></i></a>
                </div>
            </div>
        </footer>

        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/admin.js') }}"></script>
    </body>

</html>
