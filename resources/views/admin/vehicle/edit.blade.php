<x-admin-layout title="Edit Vehicle">
    <div class="flex flex-col gap-y-4 p-4 bg-gray-50 min-h-screen">
        <div class="flex flex-col border bg-white shadow rounded-lg p-4">
            <div>
                <form class="grid gap-y-4" action="{{ route('vehicles.edit', $vehicle->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-control">
                        <input class="peer" type="text" minlength="3" maxlength="9" name="license_number"
                            id="license_number" placeholder="Enter vehicle number"
                            value="{{ $vehicle->license_number }}" required>
                        <label class="form-label" for="license_number">License Number</label>
                        @error('license_number')
                        <span class="form-label text-redfire">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-control">
                        <input class="peer" type="text" name="name" id="name" placeholder="Enter vehicle name"
                            value="{{ $vehicle->name }}" required>
                        <label class="form-label" for="name">Name</label>
                        @error('name')
                        <span class="form-label text-redfire">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-control">
                        <select name="category_id" id="category_id" placeholder="Enter vehicle category"
                            value="{{ $vehicle->category_id }}" required>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{$category->id == $vehicle->category_id ?
                                'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <label class="form-label" for="category_id">Select Category:</label>
                        @error('category_id')
                        <span class="form-label text-redfire">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="grid gap-y-2">
                        <label class="font-medium text-sm text-gray-600" for="image">Upload Image</label>
                        <input name="image" id="image"
                            class="rounded-r-md transition duration-300 ease-in-out focus:border-amber form-label text-redfire select-none"
                            type="file">
                        <p class="mt-1 text-xs">SVG, PNG, JPG, or GIF
                            (Max res/size. 2048x2048px/4mb).</p>
                        @error('image')
                        <span class="form-label text-redfire">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-control">
                        <input class="peer" type="number" name="price" id="price" placeholder="Enter rent price"
                            value="{{ $vehicle->price }}" required>
                        <label class="form-label" for="price">Rent Price/day</label>
                        @error('price')
                        <span class="form-label text-redfire">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-control">
                        <select name="status" id="status" placeholder="Select vehicle status"
                            value="{{ $vehicle->status }}" required>
                            <option value="0" {{$vehicle->status == 0 ? 'selected' : '' }}>Maintenance
                            </option>
                            <option value="1" {{$vehicle->status == 1 ? 'selected' : '' }}>Available
                            </option>
                        </select>
                        <label class="form-label" for="status">Status:</label>
                        @error('status')
                        <span class="form-label text-redfire">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-between">
                        <a class="btn border border-info text-info self-end" href="{{ route('vehicles') }}">Back</a>
                        <button type="submit" class="btn bg-info text-white self-end">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
