<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Add New Admin
        </h2>
    </x-slot>
    @if (session('success'))
        <div class="relative px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    <form action="{{ route('admin.admins.store') }}" method="POST">
        @csrf

        <div class="flex flex-wrap mb-6 -mx-3">
            <div class="w-full px-3">
                <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase" for="name">
                    Name
                </label>
                <input
                    class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white @error('name') border-red-500 @enderror"
                    id="name" type="text" name="name" required>
                @error('name')
                    <p class="text-xs italic text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap mb-6 -mx-3">
            <div class="w-full px-3">
                <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase" for="email">
                    Email
                </label>
                <input
                    class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white @error('email') border-red-500 @enderror"
                    id="email" type="email" name="email" required>
                @error('email')
                    <p class="text-xs italic text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap mb-6 -mx-3">
            <div class="w-full px-3">
                <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase" for="address">
                    Address
                </label>
                <input
                    class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white @error('address') border-red-500 @enderror"
                    id="address" type="text" name="address">
                @error('address')
                    <p class="text-xs italic text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap mb-6 -mx-3">
            <div class="w-full px-3">
                <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase" for="phone">
                    Phone
                </label>
                <input
                    class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white @error('phone') border-red-500 @enderror"
                    id="phone" type="text" name="phone">
                @error('phone')
                    <p class="text-xs italic text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap mb-6 -mx-3">
            <div class="w-full px-3">
                <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase" for="password">
                    Password
                </label>
                <input
                    class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white @error('password') border-red-500 @enderror"
                    id="password" type="password" name="password" required>
                @error('password')
                    <p class="text-xs italic text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap mb-6 -mx-3">
            <div class="w-full px-3">
                <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase"
                    for="password_confirmation">
                    Confirm Password
                </label>
                <input
                    class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white @error('password_confirmation') border-red-500 @enderror"
                    id="password_confirmation" type="password" name="password_confirmation" required>
                @error('password_confirmation')
                    <p class="text-xs italic text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="flex items-center justify-between">
            <button
                class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                type="submit">
                Add Admin
            </button>
        </div>
    </form>

</x-admin-app-layout>
