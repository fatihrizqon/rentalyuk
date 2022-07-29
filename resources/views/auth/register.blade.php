<x-auth-layout title="Register">
    <div class="w-full">
        <div class="container flex min-h-screen items-center justify-center">
            <div class="card md:w-3/4 lg:w-1/3 bg-white max-h-[575px] overflow-y-auto">
                <div class="flex items-center justify-center px-3">
                    <a class="font-normal text-2xl text-center" href="{{ route('/') }}">{{ env('APP_NAME') }}</a>
                </div>

                <div class="p-3">
                    <form class="grid gap-y-4 select-none" action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="form-control">
                            <input class="peer" type="text" name="username" id="username"
                                placeholder="Enter your username" value="{{ old('username') }}" required>
                            <label class="form-label" for="username">Username</label>
                            @error('username')
                            <span class="text-redfire font-medium text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-control">
                            <input class="peer" type="text" name="name" id="name" placeholder="Enter your name"
                                value="{{ old('name') }}" required>
                            <label class="form-label" for="name">Name</label>
                            @error('name')
                            <span class="text-redfire font-medium text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-control">
                            <input class="peer" type="text" name="email" id="email" placeholder="Enter your email"
                                value="{{ old('email') }}" required>
                            <label class="form-label" for="email">Email</label>
                            @error('email')
                            <span class="text-redfire font-medium text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-control">
                            <input class="peer" type="password" name="password" id="password"
                                placeholder="Enter your password" required>
                            <label class="form-label" for="password">Password</label>
                            @error('password')
                            <span class="text-redfire font-medium text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-control">
                            <input class="peer" type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="Confirm your password" required>
                            <label class="form-label" for="password_confirmation">Password Confirmation</label>
                            @error('password_confirmation')
                            <span class="text-redfire font-medium text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="items-center">
                            <input type="checkbox" name="checkbox" id="checkbox" required>
                            <span class="ml-1 font-normal text-sm">I have read and agree to the <a
                                    class="font-medium text-blue-700" href="#">terms &
                                    conditions</a>.*</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <a class="text-sm hover:text-info " href="{{ route('login') }}">Already
                                have an Account?</a>
                            <button type="submit" class="btn border text-white bg-primary w-1/4">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-auth-layout>
