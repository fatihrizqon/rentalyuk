<x-admin-layout title="Categories">
    <div x-data="{
            open: false,
            modal: false,
            category_id: ''
            }" class="flex flex-col gap-y-4 p-4 bg-gray-50 min-h-screen">
        <div class="flex flex-col border bg-white shadow rounded-lg p-4">
            <div class="flex flex-wrap justify-between items-center">
                <div class="block">
                    <button @click="open = true" type="button" x-show="!open" class="btn text-white flex items-center">
                        <i class='bx bx-plus bx-sm text-redfire'></i>
                    </button>
                    <button @click="open = false" type="button" x-show="open" class="btn flex items-center self-end">
                        <i class='bx bx-chevron-up bx-sm text-info'></i>
                    </button>
                </div>
                <div>
                    <a class="btn text-success flex items-center justify-center"
                        href="{{ route('categories.export', ['keywords' => $keywords]) }}"><i
                            class='bx bx-spreadsheet bx-sm'></i></a>
                </div>
            </div>
            <div x-show="open" x-transition>
                <form class="grid gap-y-4 mt-4" action="{{ route('categories') }}" method="POST">
                    @csrf
                    <div class="form-control">
                        <input class="peer" type="text" name="name" id="name" placeholder="Enter category name"
                            required>
                        <label class="form-label" for="name">Category Name</label>
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
                    <div class="grid gap-y-2 justify-end">
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
                            <th class="text-left">#</th>
                            <th class="text-left">Category Name</th>
                            <th class="text-center">Image</th>
                            <th class="text-center">Total Vehicles</th>
                            <th class="text-center">Total Bookings</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td class="text-left">#</td>
                            <td class="text-left">{{ $category->name }}</td>
                            <td class="text-center">
                                @if($category->image)
                                <img class="mx-auto" width="50" src="{{asset('storage/'.$category->image)}}"
                                    alt="{{ $category->name }}">
                                @else
                                <span>N/A</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $category->vehicles_count }}</td>
                            <td class="text-center">{{ $category->bookings_count }}</td>
                            <td class="flex flex-row items-center justify-center gap-x-2">
                                <a href="{{ route('categories.edit', $category->id) }}"
                                    class="btn text-center text-white bg-info"> Edit </a>
                                <button type="button" @click="modal = true, category_id = {{ $category->id }}"
                                    class="btn text-center text-white bg-danger">
                                    Delete </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {!! $categories->appends(\Request::except('page'))->render() !!}
                </div>
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
                    <p class="text-xl">Are you sure you want to delete this category?</p>
                </div>
                <div class="flex flex-row justify-center gap-x-4">
                    <button type="button" @click="modal = false"
                        class="btn border-2 border-danger text-danger">Cancel</button>
                    <form action="{{ route('categories.delete') }}" method="POST">
                        @csrf
                        <input type="hidden" name="category_id" :value="category_id">
                        <button type="submit" class="btn border-2 border-primary text-primary">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
