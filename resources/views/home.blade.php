<x-app-layout>
    <section id="home" class="relative">
        <div class="absolute flex items-center justify-center w-full">
            <div class="w-full min-h-screen md:grid md:items-center">
                <div class="container">
                    <div class="flex flex-wrap-reverse items-center lg:mt-0 lg:py-0">
                        <div
                            class="flex flex-col items-center justify-center w-full h-full lg:w-1/2 rounded-lg bg-white">
                            <x-search date="{{ $date }}" from="" to=""></x-search>
                        </div>

                        <div class="flex flex-col items-center justify-center w-full lg:w-1/2 mt-20 md:mt-0">
                            <div class="swiper w-full select-none">
                                <div class="swiper-wrapper flex flex-row">
                                    @foreach($vehicles->sortBy('bookings_count')->take(5) as $vehicle)
                                    @if($vehicle->image)
                                    <div class="swiper-slide">
                                        <div class="w-full aspect-video relative overflow-hidden">
                                            <div class="absolute w-full h-full bg-cover bg-center transition duration-300"
                                                style="background-image: url('{{asset('storage/'.$vehicle->image)}}');">
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex">
            <div class="bg-redfire min-h-screen w-2/3"></div>

            <div class="bg-[#212121] min-h-screen w-1/3 bg-repeat bg-fixed"
                style="background-image: url(storage/images/sprinkle.svg)"></div>
        </div>
    </section>

    <section id="stats" class="md:relative flex items-center justify-center">
        <div
            class="md:absolute md:container w-full lg:rounded-lg flex flex-wrap justify-center py-6 md:shadow-md bg-fog">
            <ul class="lg:w-full grid md:grid-cols-3 lg:flex lg:flex-wrap items-center lg:justify-evenly gap-10">
                <li class="p-2 grid justify-items-center">
                    <h1 class="counters font-bold text-blackeerie text-3xl" values="{{ $categories->count() }}"></h1>
                    <h2 class="font-semibold text-blackeerie text-base">Brands</h2>
                </li>

                <li class="p-2 grid justify-items-center">
                    <h1 class="counters font-bold text-blackeerie text-3xl" values="{{ $vehicles->count() }}"></h1>
                    <h2 class="font-semibold text-blackeerie text-base">Cars</h2>
                </li>

                <li class="p-2 grid justify-items-center">
                    <h1 class="counters font-bold text-blackeerie text-3xl" values="{{ $users->count() }}">
                    </h1>
                    <h2 class="font-semibold text-blackeerie text-base">Customers</h2>
                </li>

                <li class="p-2 grid justify-items-center">
                    <h1 class="counters font-bold text-blackeerie text-3xl" values="{{ $bookings->count() }}"></h1>
                    <h2 class="font-semibold text-blackeerie text-base">Orders</h2>
                </li>
            </ul>
        </div>

        <script>
            const counters = document.querySelectorAll('.counters');
            const speed = 500;

            counters.forEach(counter => {
                const animate = () => {
                    const value = +counter.getAttribute('values');
                    const data = +counter.innerText;
                    const time = value / speed;
                    if (data < value) {
                        counter.innerText = Math.ceil(data + time);
                        setTimeout(animate, 10);
                    } else {
                        counter.innerText = value;
                    }

                }
                animate();
            });
        </script>
    </section>

    <section id="brands"
        class="flex md:pt-32 lg:pt-16 items-center justify-center bg-gradient-to-b from-redfire via-redfire to bg-redruby">
        <div class="flex justify-center py-8 bg-transparent container">
            <ul
                class="w-full grid grid-cols-2 gap-5 justify-items-center md:grid-cols-3 lg:flex lg:flex-wrap items-center lg:justify-evenly">
                @foreach($categories as $category)
                @if($category->image)
                <li>
                    <img class="hover:scale-105 transition duration-300 grayscale" width="60"
                        src="{{asset('storage/'.$category->image)}}" alt="{{ $category->name }}">
                </li>
                @endif
                @endforeach
            </ul>
        </div>
    </section>

    <section id="about" class="flex flex-wrap min-h-screen">
        <div class="flex flex-wrap w-full lg:w-1/2 bg-redruby items-start lg:items-center justify-center p-5">
            <div class="container grid gap-3 justify-items-center justify-center">
                <img class="w-full md:w-1/2" src="{{asset('storage/images/app-logo.svg')}}"
                    alt="{{ env('APP_NAME') }}" />
                <h3 class="font-bold text-lg text-white italic">service with passion</h3>
                <p class="text-base font-semibold text-white text-center">Lorem ipsum dolor, sit amet consectetur
                    adipisicing
                    elit. Corrupti, pariatur eveniet nemo tempore libero tenetur.</p>
                <ul class="w-full grid md:grid-cols-3 gap-5 p-3 lg:justify-items-start">
                    <li class="text-base font-normal text-white">✔ Self-pickup</li>
                    <li class="text-base font-normal text-white">✔ Drop-off</li>
                    <li class="text-base font-normal text-white">✔ All in package (Driver & Fuel)</li>
                    <li class="text-base font-normal text-white">✔ Welcome Snacks & Drinks</li>
                    <li class="text-base font-normal text-white">✔ Best Price in Town</li>
                    <li class="text-base font-normal text-white">✔ Insurances</li>
                    <li class="text-base font-normal text-white">✔ Quality Control Passed</li>
                    <li class="text-base font-normal text-white">✔ 24/7 Customer Service</li>
                    <li class="text-base font-normal text-white">✔ 24/7 Spare Car</li>
                </ul>
            </div>
        </div>

        <div class="flex w-full lg:w-1/2 bg-redruby items-start justify-center">
            <ul class="w-full flex flex-wrap items-center justify-center">
                @foreach($vehicles as $vehicle)
                @if($vehicle->image)

                <li class="w-full aspect-[4/3] sm:w-1/2 lg:w-1/3 group relative overflow-hidden">
                    <div class="absolute group-hover:scale-110 group-hover:bg-opacity-40 w-full h-full bg-cover bg-center transition duration-300"
                        style="background-image: url('{{asset('storage/'.$vehicle->image)}}');">

                    </div>
                </li>
                @endif
                @endforeach
            </ul>
        </div>
    </section>
</x-app-layout>
