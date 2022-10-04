<x-admin-layout title="Vehicles">
    <div x-data="{
        open: false,
        modal: false,
        vehicle_id: ''
        }" class="flex flex-col gap-y-4 p-4 bg-gray-50 min-h-screen">
        <div class="flex flex-col border bg-white shadow rounded-lg p-4">
            <div class="flex flex-wrap justify-between items-center gap-y-2">
                <div class="block">
                    <button @click="open = true" type="button" x-show="!open" class="btn text-white flex items-center">
                        <i class='bx bx-plus bx-sm text-redfire'></i>
                    </button>
                    <button @click="open = false" type="button" x-show="open" class="btn flex items-center self-end">
                        <i class='bx bx-chevron-up bx-sm text-info'></i>
                    </button>
                </div>
                <div>
                    <form class="grid gap-2 lg:flex" action="{{ route('vehicles.import') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="grid gap-y-2">
                            <label class="font-medium text-sm text-gray-600" for="import">Import Data: </label>
                            <input name="import" id="import"
                                class="rounded-r-md transition duration-300 ease-in-out focus:border-amber font-medium text-sm text-redfire select-none"
                                type="file" required>
                        </div>
                        <div class="flex flex-wrap items-center justify-between gap-x-2">
                            <button class="btn rounded text-sm bg-info text-white" type="submit">Import</button>
                            <a class="btn text-success flex items-center justify-center"
                                href="{{ route('vehicles.export') }}"><i class='bx bx-spreadsheet bx-sm'></i></a>
                        </div>
                    </form>
                    <p class="mt-1 text-xs flex flex-wrap">Format Allowed: CSV, XLS, or XLSX (<a
                            href="{{ route('/') }}storage/files/import_vehicles.xlsx"
                            class="text-info font-medium hover:text-info/50">Download Format Here</a>).
                    </p>
                    @error('import')
                    <span class="font-medium text-xs text-redfire">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div x-show="open" x-transition>
                <form class="grid gap-y-4" action="{{ route('vehicles') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-control">
                        <input class="peer" type="text" minlength="3" maxlength="9" name="license_number"
                            id="license_number" placeholder="Enter vehicle number" required>
                        <label class="form-label" for="license_number">License Number</label>
                        @error('license_number')
                        <span class="font-medium text-sm text-redfire">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-control">
                        <input class="peer" type="text" name="name" id="name" placeholder="Enter vehicle name" required>
                        <label class="form-label" for="name">Name</label>
                        @error('name')
                        <span class="font-medium text-sm text-redfire">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-control">
                        <select class="peer" name="category_id" id="category_id" placeholder="Enter vehicle category"
                            required>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <label class="form-label" for="category_id">Select Category:</label>
                        @error('category_id')
                        <span class="font-medium text-sm text-redfire">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="grid gap-y-2">
                        <label class="font-medium text-sm text-gray-600" for="image">Upload Image</label>
                        <input name="image" id="image"
                            class="rounded-r-md transition duration-300 ease-in-out focus:border-amber font-medium text-sm text-redfire select-none "
                            type="file">
                        <p class="mt-1 text-xs">SVG, PNG, JPG, GIF, or AVIF.
                            (Max res/size. 2048x2048px/4mb).</p>
                        @error('image')
                        <span class="font-medium text-sm text-redfire">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-control">
                        <input class="peer" type="number" name="price" id="price" placeholder="Enter rent price"
                            required>
                        <label class="form-label" for="price">Rent Price/day</label>
                        @error('price')
                        <span class="font-medium text-sm text-redfire">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-control justify-end">
                        <button type="submit" class="btn bg-primary text-white self-end">Create</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="flex flex-col border bg-white shadow rounded-lg p-4">
            <div class="flex flex-col w-full overflow-y-hidden">
                <table>
                    <thead>
                        <tr>
                            <th scope="col" class="text-left">
                                #
                            </th>
                            <th scope="col" class="text-left">
                                Category
                            </th>
                            <th scope="col" class="text-left">
                                Name
                            </th>
                            <th scope="col" class="text-center">
                                Image
                            </th>
                            <th scope="col" class="text-center">
                                Price
                            </th>
                            <th scope="col" class="text-center">
                                Status
                            </th>
                            <th scope="col" class="text-center">
                                Total Bookings
                            </th>
                            <th scope="col" class="text-center">

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vehicles as $vehicle)
                        <tr class="bg-white border-b hover:bg-gray-300 transition duration-300">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $vehicle->id }}
                            </td>
                            <td class="text-left">
                                {{ $vehicle->license_number }}
                            </td>
                            <td class="text-left">
                                {{ $vehicle['category']['name'] }}
                                {{ $vehicle->name }}
                            </td>
                            <td class="text-center">
                                <img width="25" src="{{ env('DO_URL') .'/'. $vehicle->image }}"
                                    alt="{{ $vehicle->name }} {{ $vehicle->license_number }}">
                            </td>
                            <td class="text-center">
                                Rp.{{ $vehicle->price }},-/day (24 hours)
                            </td>
                            <td class="text-center">
                                @if($vehicle->status === 1)
                                <span class="text-success">Available</span>
                                @else
                                <span class="text-danger">Maintenance</span>
                                @endif
                            </td>
                            <td class="text-center">
                                {{ $vehicle->bookings_count }}
                            </td>
                            <td class="flex flex-row items-center justify-center gap-x-2">
                                <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                                    class="btn text-center text-white bg-info"> Edit </a>
                                <button type="button" @click="modal = true, vehicle_id = {{ $vehicle->id }}"
                                    class="btn text-center text-white bg-danger">
                                    Delete </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div id="modal" x-show="modal" x-transition
            class="hidden fixed top-0 left-0 min-h-screen w-full bg-black/25 backdrop-blur-[3px] flex items-center justify-center">
            <div
                class="flex flex-col justify-between gap-y-4 bg-white p-8 m-4 rounded-lg w-[400px] text-gray-500 shadow-lg">
                <div class="text-center">
                    <h1 class="text-2xl"><i class='bx bx-info-circle bx-lg'></i></h1>
                </div>
                <div class="text-center">
                    <p class="text-xl">Are you sure you want to delete this vehicle?</p>
                </div>
                <div class="flex flex-row justify-center gap-x-4">
                    <button type="button" @click="modal = false"
                        class="btn border-2 border-danger text-danger">Cancel</button>
                    <form action="{{ route('vehicles.delete') }}" method="POST">
                        @csrf
                        <input class="peer" type="hidden" name="vehicle_id" :value="vehicle_id">
                        <button type="submit" class="btn border-2 border-primary text-primary">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
