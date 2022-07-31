<x-auth-layout title="Login">
    <div class="w-full">
        <div class="container flex min-h-screen items-center justify-center">
            <div class="card md:w-3/4 lg:w-1/3 bg-white max-h-[575px] overflow-y-auto">
                <div class="flex items-center justify-center px-3">
                    <a class="font-normal text-2xl text-center" href="{{ route('/') }}">{{ env('APP_NAME') }}</a>
                </div>

                <div class="p-3">
                    <form class="grid gap-y-4" action="{{ route('login') }}" method="POST">
                        @csrf
                        @if(Session::get('status'))
                        <span class="font-medium text-sm text-green-700 text-justify">{{ Session::get('status') }}
                        </span>
                        @endif
                        @if(Session::get('warning'))
                        <span class="font-medium text-sm text-red-700 text-justify">{{ Session::get('warning') }}
                        </span>
                        @endif

                        <div class="form-control">
                            <input class="peer" type="text" name="email" id="email" placeholder="Email"
                                value="{{ old('email') }}" required>
                            <label class="form-label" for="email">Email</label>
                            @error('email')
                            <span class="font-medium text-sm text-redfire">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-control">
                            <input class="peer" type="password" name="password" id="password" placeholder="Password"
                                required>
                            <label class="form-label" for="password">Password</label>
                            @error('password')
                            <span class="font-medium text-sm text-redfire">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-between">
                            <div class=" text-sm items-center">
                                <input type="checkbox" name="remember_token" id="remember_token">
                                <span class="ml-1 font-normal">Remember me</span>
                            </div>
                            <button type="submit" class="btn border text-white bg-primary w-1/4 self-end">Login</button>
                        </div>
                    </form>
                </div>

                <div class="flex flex-row items-center justify-between">
                    <a class="text-sm hover:text-info " href="{{ route('register') }}">Create New
                        Account</a>
                    <a class="text-sm hover:text-info " href="{{ route('password.request') }}">Forgot
                        Password</a>
                </div>
            </div>
        </div>
    </div>
</x-auth-layout>
