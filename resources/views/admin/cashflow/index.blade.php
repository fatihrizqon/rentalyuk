<x-admin-layout title="Cashflow Data">
    <div x-data="{
        open: false,
        modal: false,
        data: []
        }" class="flex flex-col gap-y-4 p-4 bg-gray-50 min-h-screen">
        <div class="flex flex-col border bg-white shadow rounded-lg p-4">
            <div class="flex justify-between items-center">
                <div class="block">
                    <button @click="open = true" type="button" x-show="!open" class="btn text-white flex items-center">
                        <i class='bx bx-plus bx-sm text-redfire'></i>
                    </button>
                    <button @click="open = false" type="button" x-show="open" class="btn flex items-center self-end">
                        <i class='bx bx-chevron-up bx-sm text-info'></i>
                    </button>
                </div>

                <!-- Export -->
                <div>
                    <a class="btn text-success self-end"
                        href="{{ route('cashflows.export', ['from' => $from, 'to' => $to, 'keywords' => $keywords]) }}"><i
                            class='bx bx-spreadsheet bx-sm'></i></a>
                </div>
            </div>
            <div x-show="open" x-transition>
                <form class="grid gap-y-4 mt-2" action="{{ route('cashflows') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-control">
                        <input class="peer" type="text" name="name" id="name" placeholder="Enter Transaction Name"
                            required>
                        <label class="form-label" for="name">Transaction Name</label>
                        @error('name')
                        <span class="font-medium text-sm text-redfire">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-control">
                        <select class="peer" name="type" id="type" required>
                            <option value="Credit">Credit</option>
                            <option value="Debit">Debit</option>
                        </select>
                        <label class="form-label" for="type">Select Transaction Type:</label>
                        @error('type')
                        <span class="font-medium text-sm text-redfire">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-control">
                        <input class="peer" type="number" name="value" id="value" placeholder="Enter Value" required>
                        <label class="form-label" for="value">Value</label>
                        @error('value')
                        <span class="font-medium text-sm text-redfire">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid gap-y-2 justify-end">
                        <button type="submit" class="btn bg-primary text-white self-end">Create</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="flex flex-col border bg-white shadow rounded-lg p-4">
            <div class="flex flex-col w-full overflow-y-hidden">
                <!-- Filter -->
                <div class="flex flex-wrap w-full justify-between items-start p-4">
                    <form class="grid lg:flex flex-row w-full lg:w-1/2 lg:gap-x-4 gap-y-4"
                        action="{{ route('cashflows') }}" method="GET">
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
                            <a href="{{ route('cashflows') }}" class="btn text-sm">Reset
                                Filter</a>
                        </div>
                    </form>

                    <form class="grid lg:flex lg:flex-row w-full lg:w-1/2 lg:gap-x-4 gap-y-4 self-end"
                        action="{{ route('cashflows') }}" method="GET">
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
                            <th scope="col" class="text-center">
                                @sortablelink('code', 'Transaction Code')
                            </th>
                            <th scope="col" class="text-center">
                                @sortablelink('name', 'Name')
                            </th>
                            <th scope="col" class="text-center">
                                @sortablelink('type', 'Type')
                            </th>
                            <th scope="col" class="text-center">
                                @sortablelink('value', 'Value')
                            </th>
                            <th scope="col" class="text-center">
                                @sortablelink('created_at', 'Created at')
                            </th>
                            <th scope="col" class="text-center">
                                @sortablelink('updated_at', 'Updated at')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cashflows as $cashflow)
                        <tr>
                            <td>{{ $cashflow->id }}</td>
                            <td class="text-left">
                                {{ $cashflow->code }}
                            </td>
                            <td class="text-left">
                                {{ $cashflow->name }}
                            </td>
                            <td class="text-center">
                                @if($cashflow->type === 'Debit')
                                <span class="text-success font-medium">Debit</span>
                                @else
                                <span class="text-danger font-medium">Credit</span>
                                @endif
                            </td>
                            <td class="text-center">
                                Rp.{{ $cashflow->value }},-
                            </td>
                            <td class="text-center">
                                {{ $cashflow->created_at }}
                            </td>
                            <td class="text-center">
                                {{ $cashflow->updated_at }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {!! $cashflows->appends(\Request::except('page'))->render() !!}
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
