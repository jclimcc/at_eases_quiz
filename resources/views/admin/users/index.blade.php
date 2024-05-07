<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Users Management
        </h2>
    </x-slot>
    @if (session('success'))
        <div class="relative px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    <div class="py-3">
        <a href="{{ route('admin.users.create') }}"
            class="px-4 py-3 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Add New User</a>
    </div>

    <table class="w-full my-4 bg-white rounded shadow-md text-md">
        <tbody>
            <tr class="border-b">
                <th class="p-3 px-5 text-left">ID</th>
                <th class="p-3 px-5 text-left">Name</th>
                <th class="p-3 px-5 text-left">Email</th>
                <th class="p-3 px-5 text-left">Created At</th>
                <th class="p-3 px-5 text-left">Actions</th>
            </tr>
            @forelse ($users as $user)
                <tr class="border-b hover:bg-orange-100">
                    <td class="p-3 px-5">{{ $user->id }}</td>
                    <td class="p-3 px-5">{{ $user->name }}</td>
                    <td class="p-3 px-5">{{ $user->email }}</td>
                    <td class="p-3 px-5">{{ $user->created_at }}</td>
                    <td class="p-3 px-5">
                        <a href="{{ route('admin.users.show', $user) }}"
                            class="text-blue-400 underline hover:text-blue-600">View</a>
                        <a href="{{ route('admin.users.edit', $user) }}"
                            class="ml-4 text-blue-400 underline hover:text-blue-600">Edit</a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline"
                            onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="ml-4 text-red-500 underline hover:text-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="p-3 px-5 text-center">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $users->links() }}
</x-admin-app-layout>