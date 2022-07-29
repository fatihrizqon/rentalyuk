<x-app-layout title="Email Verification">
    <div class="w-full">
        <div class="container flex min-h-screen items-center justify-center">
            <div class="card md:w-3/4 lg:w-1/3 bg-white max-h-[575px] overflow-y-auto">
                <div class="flex items-center justify-center px-3">
                    Email Verification
                </div>
                <div class="p-3 text-justify text-sm">
                    @if (session('resent'))
                    <span class="font-medium text-sm text-green-700 text-justify">A fresh verification link has been
                        sent to your email address. Please check and verify your account to complete the registration.
                    </span>
                    @else
                    <span> Before proceeding, please check your email for a verification link. If you did not receive
                        the email
                        <form class="inline-block" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit"
                                class="align-baseline text-info hover:text-primary transition duration-300">{{ __('click here to request another') }}</button>.
                        </form>
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
