<x-auth-layout title="Create a New Password">
    <div class="w-full">
        <div class="container flex min-h-screen items-center justify-center">
            <div class="card md:w-3/4 lg:w-1/3 bg-white max-h-[575px] overflow-y-auto">
                <div class="flex items-center justify-center px-3">
                    <a class="font-normal text-2xl text-center" href="{{ route('/') }}">{{ env('APP_NAME') }}</a>
                </div>

                <div class="p-3">
                    <form class="grid gap-y-4" action="{{ route('password.update') }}" method="POST">
                        @csrf
                        @if(Session::get('info'))
                        <span class="font-medium text-sm text-green-700 text-justify">{{ Session::get('info') }}
                        </span>
                        @endif
                        @if(Session::get('warning'))
                        <span class="font-medium text-sm text-red-700 text-justify">{{ Session::get('warning') }}
                        </span>
                        @endif
                        <div class="form-control">
                            <input class="peer" type="text" name="email" id="email" placeholder="Enter your email"
                                value="{{ old('email') }}" required>
                            <label class="form-label" span="email">Email</label>
                            @error('email')
                            <span class="font-medium text-sm text-redfire">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-control">
                            <input class="peer" type="password" name="password" id="password"
                                placeholder="Enter your password" required>
                            <label class="form-label" for="password">Password</label>
                            @error('password')
                            <span class="font-medium text-sm text-redfire">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-control">
                            <input class="peer" type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="Confirm your password" required>
                            <label class="font-medium text-sm " for="password_confirmation">Confirm Password</label>
                            @error('password_confirmation')
                            <span class="font-medium text-sm text-redfire">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="btn border text-white bg-primary w-1/4">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-auth-layout>
