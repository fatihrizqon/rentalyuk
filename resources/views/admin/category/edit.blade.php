<x-admin-layout title="Edit Category">
    <div class="flex flex-col gap-y-4 p-4 bg-gray-50 min-h-screen">
        <div class="flex flex-col border bg-white shadow rounded-lg p-4">
            <div class="mt-4">
                <form class="grid gap-y-4" action="{{ route('categories.edit', $category->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-control">
                        <input class="peer" type="text" name="name" id="name" placeholder="Enter new category name"
                            value="{{ $category->name }}" required>
                        <label class="form-label" for="name">Name</label>
                        @error('name')
                        <span class="font-medium text-sm text-redfire">{{ $message }}</span>
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

                    <div class="flex justify-between">
                        <a class="btn border border-info text-info self-end" href="{{ route('categories') }}">Back</a>
                        <button type="submit" class="btn bg-info text-white self-end">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
