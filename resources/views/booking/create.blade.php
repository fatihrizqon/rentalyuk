<x-app-layout title="Confirm Booking">
    <section id="booking">
        <div class="flex flex-col w-full items-center justify-center gap-4">
            <div class="flex flex-col w-full lg:w-1/2 justify-center p-4 rounded-xl bg-white shadow-md bg-center bg-fixed"
                style="background-image: url(storage/images/sprinkle.svg)">
                <div class="grid grid-cols-1 gap-4 justify-items-start mb-4">
                    <h2 class="font-normal text-3xl text-redfire"><span class=" font-bold text-redruby">Easy
                            Book</span> for your Nice Trip</h2>
                </div>
                <form class="grid gap-y-4" action="{{ route('booking.store') }}" method="POST">
                    @csrf
                    <div class="grid gap-y-4">
                        <!-- User Details -->
                        <div class="grid gap-y-4">
                            <h3 class="font-medium text-md text-blackeerie">User Details:</h3>
                            <div class="form-control">
                                <input class="peer" name="name" id="name" type="text" value="{{ $data['user']->name }}"
                                    disabled />
                                <label class="form-label" for="name">Full Name:</label>
                            </div>
                            <div class="form-control">
                                <input class="peer" name="address" id="address" type="text"
                                    value="{{ $data['user']->address }}" disabled />
                                <label class="form-label" for="address">Address:</label>
                            </div>
                            <div class="form-control">
                                <input class="peer" name="phone" id="phone" type="text"
                                    value="{{ $data['user']->phone }}" disabled />
                                <label class="form-label" for="phone">Phone:</label>
                            </div>
                        </div>
                        <!-- Booking Details -->
                        <div class="grid gap-y-4">
                            <h3 class="font-medium text-md text-blackeerie">Booking Details:</h3>
                            <div class="flex w-full justify-center">
                                <img class="bg-white" width="150"
                                    src="{{ env('DO_URL') .'/'. $data['vehicle']->image }}"
                                    alt="{{ $data['vehicle']->name }}">
                            </div>
                            <div class="form-control">
                                <input class="peer" name="vehicle" id="vehicle" type="text"
                                    value="{{ $data['vehicle']->category['name']  }} {{ $data['vehicle']->name }}"
                                    disabled />
                                <label class="form-label" for="vehicle">Vehicle:</label>
                            </div>
                            <div class="form-control">
                                <input class="peer" name="license_number" id="license_number" type="text"
                                    value="{{ $data['vehicle']->license_number }}" disabled />
                                <label class="form-label" for="license_number">Vehicle
                                    Number:</label>
                            </div>
                            <div class="form-control">
                                <input class="peer" name="from" id="from" type="datetime-local"
                                    value="{{ Carbon\Carbon::parse($data['from'])->minute(0)->second(0)->format('Y-m-d\TH:i') }}"
                                    disabled />
                                <label class="form-label" for="from">Date of Booking:</label>
                            </div>
                            <div class="form-control">
                                <input class="peer" name="to" id="to" type="datetime-local"
                                    value="{{ Carbon\Carbon::parse($data['to'])->minute(0)->second(0)->format('Y-m-d\TH:i') }}"
                                    disabled />
                                <label class="form-label" for="to">Date of Return:</label>
                            </div>
                            <div class="form-control">
                                <input class="peer" name="price" id="price" type="text"
                                    value="Rp.{{ $data['duration'] * $data['vehicle']->price }},-" disabled />
                                <label class="form-label" for="price">Total Price
                                    (Cost):</label>
                            </div>
                        </div>
                        <!-- Payment Methods -->
                        <div class="grid gap-y-2 items-start justify-start">
                            <h3 class="font-medium text-md text-blackeerie">Select Payment Methods:</h3>
                            <div class="flex flex-col gap-8 w-full justify-between items-start">
                                <div class=" flex flex-row gap-2 items-center justify-center">
                                    <input type="radio" name="payment" required>
                                    <img width="150" src="https://xendit.co/wp-content/uploads/2020/03/iconQris.png"
                                        alt="QRIS">
                                </div>
                            </div>

                        </div>
                        <div class="flex justify-between">
                            <a href="{{ URL::previous() }}"
                                class="btn border border-redfire bg-white text-redfire">Back</a>
                            <button type="submit" class="btn bg-primary text-white">Book
                                Now</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>
