<x-app-layout title="Select Vehicle">
    <section id="booking">
        <div class="w-full flex flex-col items-center justify-center gap-4 lg:container">
            <div class="text-redruby bg-white rounded-lg w-full lg:w-1/2 flex flex-col items-center justify-center ">
                <x-search date="{{ $date }}" from="{{ $from }}" to="{{ $to }}"></x-search>
            </div>
            <div
                class="flex flex-col w-full lg:w-1/2 bg-redfire text-white items-center justify-center rounded-md p-2 gap-2">
                <div class="flex flex-wrap items-center justify-center gap-1">
                    <a class="chip border bg-redfire"
                        href="{{ route('booking.search') }}?from={{ $from }}&to={{ $to }}">All
                        Categories</a>
                    @foreach($categories as $category)
                    <a class="chip border bg-redfire"
                        href="{{ route('booking.search') }}?category={{ $category->slug }}&from={{ $from }}&to={{ $to }}">{{ $category->name }}</a>
                    @endforeach
                </div>

                <div class="flex w-full lg:overflow-hidden">
                    <ul class="grid w-full overflow-x-scroll lg:overflow-hidden gap-y-2">
                        @foreach($vehicles as $vehicle)
                        <li
                            class="flex flex-row w-full items-center justify-between gap-1 text-sm hover:bg-white hover:text-redfire transition-all px-2">
                            <span class="flex w-full justify-start">{{ $vehicle->category['name'] }}
                                {{ $vehicle->name }}</span>
                            <span class="flex w-full justify-center">{{ $vehicle->license_number }}</span>
                            <span class="flex w-full justify-center">Rp.{{ $vehicle->price }},-</span>
                            <span class="flex w-full justify-end hover:text-redfire">
                                <form action="{{ route('booking.create') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="license_number" value="{{ $vehicle->license_number }}">
                                    <button type="submit"
                                        class="btn font-medium text-sm border border-white rounded-lg hover:text-redfire">Book</button>
                                </form>
                            </span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="p-2 rounded-md text-white w-full">
                    {{ $vehicles->links() }}
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
