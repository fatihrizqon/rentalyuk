<div id="header"
    class="text-white bg-redruby/50 shadow backdrop-blur-sm lg:bg-transparent lg:shadow-none lg:backdrop-blur-0">
    <div x-data="{ navigation : true }" class="container block lg:flex lg:flex-row items-center justify-between py-3">
        <ul class="flex flex-wrap justify-between items-center w-full">
            <li class="group flex items-center gap-2">
                <a class="pacifico font-medium text-xl hover:text-gray-300"
                    href="{{ route('/') }}#home">{{ env('APP_NAME') }}</a>
            </li>

            <li class="group lg:hidden">
                <button @click="navigation = !navigation" x-show="navigation" class="select-none cursor-pointer"
                    type="button">
                    <i class="bx bx-menu-alt-right bx-md"></i>
                </button>
                <button @click="navigation = !navigation" x-show="!navigation" class="select-none cursor-pointer"
                    type="button">
                    <i class="bx bx-x bx-md"></i>
                </button>
            </li>
        </ul>

        <!-- Desktop Navigation -->
        <ul class="hidden lg:flex flex-wrap items-center w-full lg:gap-6">
            <li>
                <a class="navlink" href="{{ route('/') }}#home">Home</a>
            </li>
            <li>
                <a class="navlink" href="{{ route('/') }}#about">About</a>
            </li>
            <li>
                <a class="navlink" href="{{ route('/') }}#footer">Contact</a>
            </li>
            <li>
                <a class="navlink" href="{{ route('booking') }}">Booking</a>
            </li>
        </ul>

        <ul class="lg:flex lg:flex-row lg:gap-4">
            <!-- Mobile Navigation -->
            <div x-show="!navigation" class="appereance-none" @scroll.window.throttle="navigation = true"
                @click.outside="navigation = true" x-transition>
                @guest
                <li class="lg:hidden py-2">
                    <a class="navlink" href="{{ route('login') }}">Login</a>
                </li>
                <li class="lg:hidden py-2">
                    <a class="navlink" href="{{ route('register') }}">Register</a>
                </li>
                @else
                <li class="lg:hidden py-2">
                    <a class="navlink" href="{{ route('/') }}#home">Home</a>
                </li>
                <li class="lg:hidden py-2">
                    <a class="navlink" href="{{ route('/') }}#about">About</a>
                </li>
                <li class="lg:hidden py-2">
                    <a class="navlink" href="{{ route('/') }}#footer">Contact</a>
                </li>
                <li class="lg:hidden py-2">
                    <a class="navlink" href="{{ route('booking') }}">Booking</a>
                </li>
                <hr>
                <li class="lg:hidden py-2">
                    <a class="navlink" href="{{ route('account') }}">Account
                        Settings</a>
                </li>
                <li class="lg:hidden py-2">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex w-full text-left py-1 font-light transition duration-300">Logout</button>
                    </form>
                </li>
                @endguest
            </div>

            <!-- Desktop Auth Navigations -->
            @guest
            <li class="hidden lg:flex">
                <a class="navlink" href="{{ route('login') }}">Login</a>
            </li>
            <li class="hidden lg:flex">
                <a class="navlink" href="{{ route('register') }}">Register</a>
            </li>
            @else
            <li x-data="{ account : false }" class="py-2 hidden lg:flex lg:flex-row select-none" x-show="navigation"
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
                                <a href="{{ route('account') }}" class="px-2 py-1 hover:text-gray-600">Account
                                    Settings</a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-2 py-1 hover:text-gray-600">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            @endguest
        </ul>
    </div>
</div>
