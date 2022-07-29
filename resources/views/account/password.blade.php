<x-app-layout title="Change Password">
    <section class="min-h-screen bg-redruby/5 flex items-start justify-center pt-16">
        <div class="flex flex-col w-full container">
            <div class="flex flex-col w-full items-center justify-center gap-4">
                <div
                    class="flex flex-col overflow-hidden justify-center items-center w-full gap-2 py-4 shadow-md bg-redfire rounded-3xl">
                    <img width="250" class="flex h-24 w-24 bg-white rounded-full border"
                        src="{{ route('/') }}/storage/{{ $user->image }}" alt="{{ $user->username }}">

                    <span class="text-white pacifico text-lg">
                        {{ $user->name }}
                    </span>
                </div>

                <div class="w-full lg:w-2/3 items-start bg-white justify-center shadow-md p-4 rounded-lg">
                    <h1 class="font-medium border-b mb-4">Change Password:</h1>
                    <form class="grid gap-y-4 w-full" action="{{ route('password.edit') }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-control">
                            <input class="peer" type="password" name="current_password" id="current_password"
                                placeholder="Enter your current password">
                            <label class="form-label" for="current_password">Current Password</label>
                            @error('current_password')
                            <span class="font-medium text-sm text-redfire">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-control">
                            <input class="peer" type="password" name="password" id="password"
                                placeholder="Enter your new password">
                            <label class="form-label" for="password">New Password</label>
                            @error('password')
                            <span class="font-medium text-sm text-redfire">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-control">
                            <input class="peer" type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="Confirm your new password">
                            <label class="form-label" for="password_confirmation">Confirm Password</label>
                            @error('password_confirmation')
                            <span class="font-medium text-sm text-redfire">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex items-center justify-between">
                            <a href="{{ route('account') }}">Back to Account Settings</a>
                            <button type="submit" class="btn text-white bg-primary">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </section>
</x-app-layout>
