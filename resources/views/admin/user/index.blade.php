<x-admin-layout title="Users">
    <div x-data="{
            open: false,
            modal: false,
            user_id: ''
            }" class="flex flex-col gap-y-4 p-4 bg-gray-50 min-h-screen">
        <div class="flex flex-col border bg-white shadow rounded-lg p-4">
            <div class="flex flex-wrap justify-end items-center">
                <a class="btn text-success flex items-center justify-center" href="{{ route('users.export') }}"><i
                        class='bx bx-spreadsheet bx-sm'></i></a>
            </div>
        </div>
        <div class="flex flex-col border bg-white shadow rounded-lg p-4">
            <div class="flex flex-col w-full overflow-y-hidden">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">Phone</th>
                            <th class="text-center">Total Bookings</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">Updated At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->address }}</td>
                            <td>{{ $user->phone }}</td>
                            <td class="text-center">{{ $user->bookings_count }}</td>
                            <td class="text-center">{{ $user->created_at }}</td>
                            <td class="text-center">{{ $user->updated_at }}</td>
                            <td>
                                @if(!$user->admin)
                                <form class="grid w-full gap-y-4 titillium-web" action="{{ route('admin.create') }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <button type="submit" class="border">Make Admin</button>
                                </form>
                                @else
                                @if($user->username != 'admin')
                                <form class="grid w-full gap-y-4 titillium-web" action="{{ route('admin.delete') }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <button type="submit" class="border">Demote</button>
                                </form>
                                @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {!! $users->appends(\Request::except('page'))->render() !!}
                </div>
            </div>
        </div>


    </div>

</x-admin-layout>
