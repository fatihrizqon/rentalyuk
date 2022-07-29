<x-app-layout title="User Profile">
    <section x-data="{
        booking: false,
        image: false,
        data : []
        }" class="min-h-screen bg-redruby/5 flex items-start justify-center pt-16">
        <div class="flex flex-col w-full container">
            <div class="flex flex-col w-full items-center justify-center gap-4">
                <div
                    class="flex flex-col overflow-hidden justify-center items-center w-full gap-2 py-4 shadow-md bg-redfire rounded-3xl">
                    <img width="250" class="flex h-24 w-24 bg-white rounded-full border"
                        src="{{ route('/') }}/storage/{{ $user->image }}" alt="{{ $user->username }}">
                    <span class=" text-sm text-center">
                        <button @click="image = true" class="btn text-white hover:text-white/50 rounded-md border">
                            Edit Picture
                        </button>
                    </span>

                    @error('image')
                    <span class="form-label text-redfire bg-white p-2 rounded">{{ $message }}</span>
                    @enderror

                    <span class="text-white pacifico text-lg">
                        {{ $user->name }}
                    </span>
                </div>

                <div class="w-full flex flex-col lg:flex-row gap-4">
                    <!-- Account Settings -->
                    <div class="w-full lg:w-2/3 items-start bg-white justify-center shadow-md p-4 rounded-lg">
                        <h1 class="font-medium border-b mb-4">Account Settings:</h1>
                        <form class="grid gap-y-4 w-full" action="{{ route('account') }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-control">
                                <input class="text-slate-400 border-slate-400 select-none" type="email" name="email"
                                    id="email" placeholder="Enter your email" value="{{ $user->email ?? old('email') }}"
                                    required disabled>
                                <label class="form-label" for="email">E-mail</label>
                                @error('email')
                                <span class="form-label text-redfire">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-control">
                                <input class="text-slate-400 border-slate-400 select-none" type="text" name="username"
                                    id="username" placeholder="Enter your username"
                                    value="{{ $user->username ?? old('username') }}" required disabled>
                                <label class="form-label" for="username">Username</label>
                                @error('username')
                                <span class="form-label text-redfire">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-control">
                                <input class="peer" type="text" name="name" id="name" placeholder="Enter your name"
                                    value="{{ $user->name ?? old('name') }}" required>
                                <label class="form-label" for="name">Name</label>
                                @error('name')
                                <span class="form-label text-redfire">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-control">
                                <input class="peer" type="number" name="phone" id="phone" placeholder="Enter your phone"
                                    value="{{ $user->phone ?? old('phone') }}" required>
                                <label class="form-label" for="phone">Phone</label>
                                @error('phone')
                                <span class="form-label text-redfire">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-control">
                                <input class="peer" type="text" name="address" id="address"
                                    placeholder="Enter your address" value="{{ $user->address ?? old('address') }}"
                                    required>
                                <label class="form-label" for="address">Address</label>
                                @error('address')
                                <span class="form-label text-redfire">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex items-center justify-between">
                                <a href="{{ route('password.edit') }}">Change
                                    Password</a>
                                <button type="submit" class="btn text-white bg-primary">Update Account</button>
                            </div>
                        </form>
                    </div>

                    <!-- Histories -->
                    <div class="w-full lg:w-1/3 bg-white flex flex-col shadow-md p-4 rounded-lg">
                        <h1 class="font-medium border-b">Previous Bookings:</h1>
                        <ul class="divide-y-2 divide-gray-100 text-xs flex flex-col justify-between">
                            @foreach($bookings as $booking)
                            <li @click="booking = true, data = {{ $bookings[$loop->index] }}"
                                class="p-1 rounded-md hover:bg-redfire hover:text-fog items-center justify-between flex transition duration-300 ease-in-out group">
                                <span>{{ $loop->index+1 }}. {{ $booking->code }}</span>
                                @if($booking->status == 1)
                                <span
                                    class="chip border-success text-success group-hover:border-white group-hover:text-white">Paid</span>
                                @elseif(Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($booking->updated_at)) > 1
                                && $booking->status == 0)
                                <span
                                    class="chip border-danger text-danger group-hover:border-white group-hover:text-white">Canceled</span>
                                @else
                                <span
                                    class="chip border-warning text-warning group-hover:border-white group-hover:text-white">Unpaid</span>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                        <!-- {!! $bookings->appends(\Request::except('page'))->render() !!} -->
                    </div>
                </div>

                <!-- Quick Book -->
                <div class="w-full items-start justify-center flex flex-col lg:flex-row gap-4">
                    @foreach($vehicles as $vehicle)
                    <div class="w-full lg:w-1/5 bg-white shadow-md rounded-md items-center justify-center">
                        <div class="w-full aspect-[4/3] group relative overflow-hidden">
                            <div class="absolute group-hover:scale-110 group-hover:bg-opacity-40 w-full h-full bg-cover bg-center transition duration-300"
                                style="background-image: url('{{ route('/') }}/storage/{{ $vehicle->image }}');">
                            </div>
                        </div>
                        <div>
                        </div>
                        <h1 class="font-semibold text-center">{{ $vehicle->category['name'] }} {{ $vehicle->name }}
                        </h1>
                        <form class="flex justify-center p-4" action="{{ route('booking.create') }}" method="POST">
                            @csrf
                            <input class="peer" type="hidden" name="license_number"
                                value="{{ $vehicle->license_number }}">
                            <input class="peer" type="hidden" name="from" value="{{ $from }}">
                            <input class="peer" type="hidden" name="to" value="{{ $to }}">
                            <button type="submit" class="btn text-white bg-redfire rounded-lg">Book Now</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div id="modal" class="hidden">
            <div id="booking" x-show="booking" x-transition
                class="fixed top-0 left-0 min-h-screen w-full bg-black/25 backdrop-blur-[2px] flex items-center justify-center">
                <div
                    class="flex flex-col justify-between gap-y-2 bg-white p-4 m-4 rounded-lg w-[400px] text-gray-500 shadow-lg">
                    <div class="flex flex-col justify-center">
                        <h1 class="text-xl text-center">Booking Information</h1>
                        <div class="flex flex-col p-[1mm] select-none IBM bg-white">
                            <div class="text-justify my-2 font-medium">
                                <table class="info">
                                    <tbody class="gap-0">
                                        <tr>
                                            <td>Code</td>
                                            <td><span x-text="data.code"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Username</td>
                                            <td><span x-text="data.user.username"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td><span x-text="data.user.phone"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td><span x-text="data.user.address"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Vehicle</td>
                                            <td><span x-text="data.vehicle.name"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Rent From</td>
                                            <td><span x-text="data.from"></span></td>
                                        </tr>
                                        <tr>
                                            <td>To</td>
                                            <td><span x-text="data.to"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Cost</td>
                                            <td>Rp.<span x-text="data.price"></span>,-</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="flex flex-col items-center justify-center text-xs">
                                <div class="flex flex-col items-center justify-center w-full gap-y-2">
                                    <span>
                                        Please scan following <span class="font-semibold text-black">QRIS</span> and
                                        complete your booking payment:
                                    </span>
                                    <img width="100" src="https://hexdocs.pm/qr_code/docs/qrcode.svg" alt="QRIS">
                                </div>

                                <!-- <div class="flex flex-col items-center justify-center w-full gap-y-2">
                                    <span>
                                        Please scan following <span class="font-semibold text-black">QRIS</span> and
                                        complete your booking payment:
                                    </span>
                                    <img width="100" src="https://hexdocs.pm/qr_code/docs/qrcode.svg" alt="QRIS">
                                </div> -->
                            </div>
                        </div>
                        <div>
                            <button @click="booking = false"
                                class="btn text-xs rounded-lg bg-danger text-white">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="image" id="image" x-show="image" x-transition
                class="fixed top-0 left-0 min-h-screen w-full bg-black/25 backdrop-blur-[2px] flex items-center justify-center">
                <div
                    class="flex flex-col justify-between gap-y-2 bg-white p-4 m-4 rounded-lg w-[400px] text-gray-500 shadow-lg">
                    <div class="flex flex-col justify-center"></div>
                    <div class="flex justify-between">
                        <form class="grid gap-y-4 w-full" action="{{ route('account') }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-control items-center justify-center">
                                <label for="">Current Image:</label>
                                <img width="50" class="flex h-24 w-24 bg-white rounded-full border"
                                    src="{{ route('/') }}/storage/{{ $user->image }}" alt="{{ $user->username }}">
                            </div>
                            <div class="form-control">
                                <label for="image">Select Image: </label>
                                <input class="peer" type="file" name="image" id="image" required>
                            </div>
                            <div class="flex items-center justify-between">
                                <button @click="image = false"
                                    class="btn rounded-lg bg-danger text-white">Close</button>
                                <button type="submit" @click="image = false"
                                    class="btn rounded-lg bg-primary text-white">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-app-layout>
