<div class="flex w-full h-full justify-center shadow-md bg-center bg-fixed select-none"
    style="background-image: url(/images/sprinkle.svg)">
    <div class="grid w-full p-4">
        <div class="p-2">
            <h2 class="font-normal text-3xl text-redfire"><span class="font-bold text-redruby">Easy
                    Book</span> for your nice trip</h2>
            <h3 class="font-semibold text-md text-redfire">Find what you needs below:</h3>
        </div>
        <form class="grid gap-y-4 w-full p-2" action="{{ route('booking.search') }}" method="GET">
            <div class="grid gap-4 lg:flex lg:flex-col w-full">
                <div class="grid gap-4 lg:flex items-start w-full">
                    <div class="form-control w-full">
                        <input class="peer" name="from" class="w-full" type="datetime-local"
                            value="{{ Carbon\Carbon::parse($from)->minute(0)->second(0)->format('Y-m-d\TH:i') ?? Carbon\Carbon::parse($date)->minute(0)->second(0)->format('Y-m-d\TH:i') }}" />
                        <label class="form-label" for="from"> Date of
                            Booking: </label>
                        @error('from')
                        <span class="font-medium text-sm text-redfire">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-control w-full">
                        <input class="peer" name="to" class="w-full" type="datetime-local"
                            value="{{ Carbon\Carbon::parse($to)->minute(0)->second(0)->format('Y-m-d\TH:i') ?? Carbon\Carbon::parse($date)->minute(0)->second(0)->format('Y-m-d\TH:i') }}" />
                        <label class="form-label" for="to">Date of
                            Return:</label>
                        @error('to')
                        <span class="font-medium text-sm text-redfire">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="flex justify-center">
                    <button type="submit"
                        class="transition-all duration-300 text-white py-1 px-2 rounded-lg hover:border-0 bg-redfire hover:contrast-150 focus:contrast-125">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>
