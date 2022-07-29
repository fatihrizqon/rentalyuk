<div x-data="{ alert : true}" x-show="alert" x-transition
    class="flex p-4 mx-2 mb-4 bg-warning rounded-lg items-center justify-between gap-1 text-white shadow-md"
    role="alert">
    <div x-show="alert" class="flex items-center gap-1">
        <div class="hidden md:flex gap-1">
            <i class='bx bxs-error bx-sm'></i>
        </div>
        {{ Session::get('warning') }}
    </div>
    <button @click="alert = false" class="flex items-center justify-center text-redfire"><i
            class='bx bx-x bx-sm'></i></button>
</div>
