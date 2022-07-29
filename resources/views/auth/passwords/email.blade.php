<x-auth-layout title="Password Reset">
    <div class="w-full">
        <div class="container flex min-h-screen items-center justify-center">
            <div class="card md:w-3/4 lg:w-1/3 bg-white max-h-[575px] overflow-y-auto">
                <div class="flex items-center justify-center px-3">
                    <a class="font-normal text-2xl text-center" href="{{ route('/') }}">{{ env('APP_NAME') }}</a>
                </div>

                <div class="p-3">
                    <form class="grid gap-y-4" action="{{ route('password.email') }}" method="POST">
                        @csrf
                        @if(Session::get('warning'))
                        <span class="font-medium text-sm text-red-700 text-justify">{{ Session::get('warning') }}
                        </span>
                        @endif
                        @if(Session::get('status'))
                        <span class="font-medium text-sm text-green-700 text-justify">{{ Session::get('status') }}
                            <a class="text-smtext-black" href="{{ route('login') }}">Back to
                                Login Page</a> </span>
                        @else
                        <div class="form-control">
                            <input class="peer" type="text" name="email" id="email" placeholder="Enter your Email"
                                value="{{ old('email') }}" required>
                            <label class="form-label" for="email">Email</label>
                            @error('email')
                            <span class="font-medium text-sm text-redfire">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-center justify-between">
                            <a class="text-sm" href="{{ route('login') }}">Back to
                                Login Page</a>
                            <button type="submit" class="btn border text-white bg-primary w-1/4">Submit</button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-auth-layout>
