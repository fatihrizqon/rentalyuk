<x-app-layout title="Create Booking">
    <section id="booking">
        <div class="w-full flex flex-col items-center justify-center gap-4 lg:container">
            <div class="text-redruby bg-white rounded-lg w-full lg:w-1/2 flex flex-col items-center justify-center">
                <x-search date="{{ $date }}" from="" to=""></x-search>
            </div>
        </div>
    </section>
</x-app-layout>
