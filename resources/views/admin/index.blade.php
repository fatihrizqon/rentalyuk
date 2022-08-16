<x-admin-layout title="Dashboard">
    <div class="flex w-full flex-col min-h-screen p-4 gap-4 bg-fog">
        <!-- Cards -->
        <div class="flex flex-col sm:flex-row w-full items-start gap-4 justify-around overflow-hidden">
            <div class="admin-card w-full sm:w-1/2 lg:w-1/4 h-48 flex flex-col gap-4">
                <div class="w-full flex items-center justify-between">
                    <span class="font-medium text-md md:text-lg">Registered Users</span>
                    <a class="text-sm" href="{{ route('users') }}">View Details</a>
                </div>
                <span class="w-full font-bold text-md md:text-lg">{{ $users->count() }}</span>
                <span class="w-full font-medium text-sm md:text-md text-green-500 text-left">
                    {{ $users->where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->count() }}
                    <span class="text-sm md:text-md">since
                        last week</span></span>
            </div>
            <div class="admin-card w-full sm:w-1/2 lg:w-1/4 h-48 flex flex-col gap-4">
                <div class="w-full flex items-center justify-between">
                    <span class="font-semibold text-md md:text-lg">Last Month Bookings</span>
                    <a class="text-sm" href="{{ route('bookings') }}">View Details</a>
                </div>
                <span
                    class="w-full font-bold text-md md:text-lg">{{ $bookings->where('created_at', '>=', \Carbon\Carbon::today()->subDays(30))->count() }}</span>
                <span class="w-full font-medium text-sm md:text-md text-green-500 text-left">
                    {{ $bookings->where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->count() }}
                    <span class="text-sm md:text-md">since
                        last week</span></span>
            </div>
            <div class="admin-card w-full sm:w-1/2 lg:w-1/4 h-48 flex flex-col gap-4">
                <div class="w-full flex items-center justify-between">
                    <span class="font-semibold text-md md:text-lg">Revenue</span>
                    <a class="text-sm" href="{{ route('cashflows') }}">View Details</a>
                </div>
                <span class="w-full font-bold text-md md:text-lg">
                    <?php
                        $revenue = 0;
                        for ($i=0; $i < $bookings->count() ; $i++) { 
                            $revenue+=$bookings[$i]->price;
                        }
                    ?>
                    Rp.{{ $revenue }},-
                </span>
                <span class="w-full font-medium text-sm md:text-md text-green-500 text-left">
                    <?php
                        $revenue = 0;
                        for ($i=0; $i < $bookings->where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->count() ; $i++) { 
                            $revenue+=$bookings[$i]->price;
                        }
                    ?>
                    Rp.{{ $revenue }},-
                    <span class="text-sm md:text-md">since
                        last week</span>
                </span>
            </div>
            <div class="admin-card w-full sm:w-1/2 lg:w-1/4 h-48 flex flex-col gap-4">
                <div class="w-full flex items-center justify-between">
                    <span class="font-semibold text-md md:text-lg">Off Duty Vehicles</span>
                    <a class="text-sm" href="{{ route('vehicles') }}">View Details</a>
                </div>
                <span class="w-full font-bold text-md md:text-lg">{{ $vehicles->where('status', 0)->count() }}</span>
                <span class="w-full font-medium text-sm md:text-md text-green-500 text-left">
                    {{ $vehicles->count() }}
                    <span class="text-sm md:text-md">from total vehicles</span></span>
            </div>

        </div>

        <!-- Charts -->
        <div class=" flex flex-col md:flex-row w-full items-start gap-4 justify-around">
            <div
                class="w-full  md:w-2/3 lg:w-3/4 lg:h-full rounded-lg bg-white shadow-sm border flex flex-col items-center justify-start p-4">
                <canvas id="bookingChart"></canvas>
            </div>
            <div
                class="w-full  md:w-1/3 lg:w-1/4 lg:h-full rounded-lg bg-white shadow-sm border flex flex-col items-center justify-start p-4">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>

        <!-- Tables -->
        <div class="flex flex-col md:flex-row w-full items-start gap-4 justify-around overflow-hidden">
            <div
                class="flex flex-col w-full md:w-1/2 rounded-lg bg-white shadow-sm border p-4 overflow-x-scroll lg:overflow-hidden">
                <table>
                    <thead>
                        <tr>
                            <th scope="col" class="text-left text-xs p-1">

                            </th>
                            <th scope="col" class="text-left text-xs p-1">
                                @sortablelink('code', 'Booking Code')
                            </th>
                            <th scope="col" class="text-left text-xs p-1">
                                @sortablelink('user_id', 'Username')
                            </th>
                            <th scope="col" class="text-left text-xs p-1">
                                @sortablelink('vehicle_id', 'Vehicle')
                            </th>
                            <th scope="col" class="text-center text-xs p-1">
                                @sortablelink('status', 'Status')
                            </th>
                            <th scope="col" class="text-left text-xs p-1">

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td>#</td>
                            <td class="text-left text-xs p-1">
                                {{ $booking->code }}
                            </td>
                            <td class="text-left text-xs p-1">
                                {{ $booking->user['username'] }}
                            </td>
                            <td class="text-left text-xs p-1">
                                {{ $booking->vehicle['name'] }}
                            </td>
                            <td class="text-center text-xs p-1">
                                @if($booking->status == 1)
                                <span
                                    class="chip border-success text-success group-hover:border-white group-hover:text-white">Paid</span>
                                @elseif(Carbon\Carbon::now()->diffInDays(Carbon\Carbon::parse($booking->updated_at))
                                > 1
                                && $booking->status == 0)
                                <span
                                    class="chip border-danger text-danger group-hover:border-white group-hover:text-white">Canceled</span>
                                @else
                                <span
                                    class="chip border-warning text-warning group-hover:border-white group-hover:text-white">Unpaid</span>
                                @endif
                            </td>
                            <td class="text-left text-xs p-1">
                                {{ $booking->created_at }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div
                class="flex flex-col w-full md:w-1/2 rounded-lg bg-white shadow-sm border p-4 overflow-x-scroll lg:overflow-hidden">
                <table>
                    <thead>
                        <tr>
                            <th scope="col" class="text-left text-xs p-1">

                            </th>
                            <th scope="col" class="text-center text-xs p-1">
                                @sortablelink('code', 'Transaction Code')
                            </th>
                            <th scope="col" class="text-center text-xs p-1">
                                @sortablelink('name', 'Name')
                            </th>
                            <th scope="col" class="text-center text-xs p-1">
                                @sortablelink('type', 'Type')
                            </th>
                            <th scope="col" class="text-center text-xs p-1">
                                @sortablelink('value', 'Value')
                            </th>
                            <th scope="col" class="text-center text-xs p-1">
                                @sortablelink('created_at', 'Created at')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cashflows as $cashflow)
                        <tr>
                            <td>#</td>
                            <td class="text-left text-xs p-1">
                                {{ $cashflow->code }}
                            </td>
                            <td class="text-left text-xs p-1">
                                {{ $cashflow->name }}
                            </td>
                            <td class="text-center text-xs p-1">
                                @if($cashflow->type === 'Debit')
                                <span class="text-success font-medium">Debit</span>
                                @else
                                <span class="text-danger font-medium">Credit</span>
                                @endif
                            </td>
                            <td class="text-center text-xs p-1">
                                Rp.{{ $cashflow->value }},-
                            </td>
                            <td class="text-center text-xs p-1">
                                {{ $cashflow->created_at }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        const bctx = document.getElementById('bookingChart');
        const cctx = document.getElementById('categoryChart');
        const bookingy = JSON.parse(`{!! json_encode($bookingChart['y']) !!}`);
        const bookingx = JSON.parse(`{!! json_encode($bookingChart['x']) !!}`);
        const categoryy = JSON.parse(`{!! json_encode($categoryChart['y']) !!}`);
        const categoryx = JSON.parse(`{!! json_encode($categoryChart['x']) !!}`);
        const bookings = {
            labels: bookingy,
            datasets: [{
                label: 'Booking Data',
                data: bookingx,
                backgroundColor: [
                    '#C51162',
                    '#AA00FF',
                    '#6200EA',
                    '#304FFE',
                    '#0091EA',
                    '#00B8D4',
                    '#C51162',
                    '#00BFA5',
                    '#00C853',
                    '#FF6F00',
                    '#BF360C',
                    '#2962FF',
                ]
            }]
        };
        const categories = {
            labels: categoryx,
            datasets: [{
                label: 'Category Data',
                data: categoryy,
                backgroundColor: [
                    '#C51162',
                    '#AA00FF',
                    '#6200EA',
                    '#304FFE',
                    '#0091EA',
                    '#00B8D4',
                    '#C51162',
                    '#00BFA5',
                    '#00C853',
                    '#FF6F00',
                    '#BF360C',
                    '#2962FF',
                ]
            }]
        };
        const bookingChart = new Chart(bctx, {
            type: 'line',
            data: bookings,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                maintainAspectRatio: false,
                responsive: true,
            },
        });
        const categoryChart = new Chart(cctx, {
            type: 'doughnut',
            data: categories,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
            maintainAspectRatio: false,
            responsive: true,
        });
    </script>
</x-admin-layout>
