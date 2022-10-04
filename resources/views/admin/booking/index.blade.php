<x-admin-layout title="Booking Data">
    <div x-data="{
        open: false,
        modal: false,
        data: []
        }" class="flex flex-col gap-y-4 p-4 bg-white min-h-screen">
        <div class="flex flex-col border bg-white shadow-sm rounded-lg p-4">
            <div class="flex flex-row justify-end items-center">
                <!-- Export -->
                <div>
                    <a class="btn text-success self-end"
                        href="{{ route('bookings.export', ['from' => $from, 'to' => $to, 'keywords' => $keywords]) }}"><i
                            class='bx bx-spreadsheet bx-sm'></i></a>
                </div>
            </div>

        </div>

        <div class="flex flex-col border bg-white shadow-sm rounded-lg p-4">
            <div class="flex flex-col w-full overflow-y-hidden">
                <!-- Filter -->
                <div class="flex flex-wrap w-full justify-between items-start p-4">
                    <form class="grid lg:flex flex-row w-full lg:w-1/2 lg:gap-x-4 gap-y-4"
                        action="{{ route('bookings') }}" method="GET">
                        <div class="form-control">
                            <input class="peer" name="from" type="datetime-local" value="{{ $from ?? $date }}" />
                            <label class="form-label" for="from">Select Date From:</label>
                        </div>
                        <div class="form-control">
                            <input class="peer" name="to" type="datetime-local" value="{{ $to ?? $date }}" />
                            <label class="form-label" for="to">To:</label>
                        </div>
                        <div class="flex flex-row-reverse lg:flex-row items-end justify-between gap-x-2">
                            <button type="submit"
                                class="btn border border-gray-500 rounded text-gray-500 text-sm">Filter</button>
                            <a href="{{ route('bookings') }}" class="btn text-sm">Reset
                                Filter</a>
                        </div>
                    </form>

                    <form class="grid lg:flex lg:flex-row w-full lg:w-1/2 lg:gap-x-4 gap-y-4 self-end"
                        action="{{ route('bookings') }}" method="GET">
                        <div class="form-control w-full">
                            <input class="peer" name="keywords" id="keywords" type="text"
                                value="{{ $keywords ?? old('keywords') }}" placeholder="Enter Booking Code" required />
                            <label class="form-label" for="keywords">Search by Code:</label>
                            @error('keywords')
                            <span class="font-medium text-sm text-redfire">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-row-reverse items-end">
                            <button type="submit"
                                class="btn border border-gray-500 rounded text-gray-500 text-sm">Find</button>
                        </div>
                    </form>
                    @error('from')
                    <span class="font-medium text-sm text-redfire">Please select a valid date range.</span>
                    @enderror
                    @error('to')
                    <span class="font-medium text-sm text-redfire items-end">Please select a valid date
                        range.</span>
                    @enderror
                </div>

                <table>
                    <thead>
                        <tr>
                            <th scope="col" class="text-left">
                                #
                            </th>
                            <th scope="col" class="text-left">
                                @sortablelink('code', 'Booking Code')
                            </th>
                            <th scope="col" class="text-left">
                                @sortablelink('user_id', 'Username')
                            </th>
                            <th scope="col" class="text-left">
                                @sortablelink('vehicle_id', 'Vehicle')
                            </th>
                            <th scope="col" class="text-center">
                                <span class="font-medium text-success">@sortablelink('from', 'Booking')</span>
                                /
                                <span class="font-medium text-info">@sortablelink('to', 'Return')</span>
                            </th>
                            <th scope="col" class="text-center">
                                @sortablelink('price', 'Revenue')
                            </th>
                            <th scope="col" class="text-center">
                                @sortablelink('status', 'Status')
                            </th>
                            <th scope="col" class="text-center">
                                @sortablelink('created_at', 'Created at')
                            </th>
                            <th scope="col" class="text-center">
                                @sortablelink('updated_at', 'Updated at')
                            </th>
                            <th scope="col" class="text-center">

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>#</td>
                            <td class="text-left">
                                {{ $booking->code }}
                            </td>
                            <td class="text-left">
                                {{ $booking->user['username'] }}
                            </td>
                            <td class="text-left">
                                {{ $booking->vehicle['name'] }}
                            </td>
                            <td class="text-center">
                                <span
                                    class="text-success">{{ Carbon\Carbon::parse($booking->from)->minute(0)->second(0)->format('h:i A d/m/y') }}</span>
                                /
                                <span
                                    class="text-info">{{ Carbon\Carbon::parse($booking->to)->minute(0)->second(0)->format('h:i A d/m/y') }}</span>

                            </td>
                            <td class="text-center">
                                Rp.{{ $booking->price }},-
                            </td>
                            <td class="text-center">
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
                            </td>
                            <td class="text-center">
                                {{ $booking->created_at }}
                            </td>
                            <td class="text-center">
                                {{ $booking->updated_at }}
                            </td>
                            <td class="flex flex-row items-center justify-center gap-x-2">
                                @if($booking->status === 0 &&
                                Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($booking->updated_at)) < 1)<button
                                    type="button" @click="modal = true, data = {{ $bookings[$loop->index] }}"
                                    class="btn text-center text-white bg-primary">
                                    Action </button>
                                    @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {!! $bookings->appends(\Request::except('page'))->render() !!}
                </div>
            </div>
        </div>

        <div id="modal" x-show="modal" x-transition
            class="fixed top-0 left-0 min-h-screen w-full bg-black/25 backdrop-blur-[3px] flex items-center justify-center">
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

                                        <td><span x-text="data.user"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>

                                        <td><span x-text="data.phone"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Address</td>

                                        <td><span x-text="data.address"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Vehicle</td>

                                        <td><span x-text="data.vehicle"></span></td>
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
                        <div class="flex flex-col items-center gap-y-2 justify-center text-xs">
                            <form class="grid w-full gap-y-4 titillium-web" action="{{ route('bookings.update') }}"
                                method="POST">
                                @method('PUT')
                                @csrf
                                <input type="hidden" name="code" :value="data.code">
                                <div class="grid gap-y-2">
                                    <label class="font-medium text-sm" for="status">Select Action:</label>
                                    <select class="border rounded-lg" name="status" id="status"
                                        placeholder="Enter vehicle category" required>
                                        <option value="0">Unpaid</option>
                                        <option value="1">Paid</option>
                                    </select>
                                    @error('status')
                                    <span class="font-medium text-sm text-redfire">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="flex items-center justify-between">
                                    <button type="button" @click="modal = false"
                                        class="btn rounded-lg bg-danger text-white self-end">Cancel</button>
                                    <button type="submit"
                                        class="btn rounded-lg bg-primary text-white self-end">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
