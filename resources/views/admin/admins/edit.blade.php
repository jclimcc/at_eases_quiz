<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            Edit Admin
        </h2>
    </x-slot>
    @if (session('success'))
        <div class="relative px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    <form action="{{ route('admin.admins.update', $admin) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="flex flex-wrap mb-6 -mx-3">
            <div class="w-full px-3">
                <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase" for="name">
                    Name
                </label>
                <input
                    class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white @error('name') border-red-500 @enderror"
                    id="name" type="text" name="name" value="{{ old('name', $admin->name) }}" required>
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
                    id="email" type="email" name="email"value="{{ old('email', $admin->email) }}" required>
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
                    id="address" type="text" name="address" value="{{ old('address', $admin->address) }}">
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
                    id="phone" type="text" name="phone" value="{{ old('phone', $admin->phone) }}">
                @error('phone')
                    <p class="text-xs italic text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="flex flex-wrap mb-6 -mx-3">
            <div class="w-full px-3">
                <div class="mt-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" class="form-checkbox" name="change_password" id="change_password">
                        <span class="ml-2">Change Password</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap mb-6 -mx-3" id="password_fields" style="display: none;">
            <div class="w-full px-3">
                <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase" for="password">
                    Password
                </label>
                <input
                    class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white @error('password') border-red-500 @enderror"
                    id="password" type="password" name="password">
                @error('password')
                    <p class="text-xs italic text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex flex-wrap mb-6 -mx-3" id="password_confirmation_fields" style="display: none;">
            <div class="w-full px-3">
                <label class="block mb-2 text-xs font-bold tracking-wide text-gray-700 uppercase"
                    for="password_confirmation">
                    Confirm Password
                </label>
                <input
                    class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white @error('password_confirmation') border-red-500 @enderror"
                    id="password_confirmation" type="password" name="password_confirmation">
                @error('password_confirmation')
                    <p class="text-xs italic text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <script>
            document.getElementById('change_password').addEventListener('change', function() {
                var passwordFields = document.getElementById('password_fields');
                var passwordConfirmationFields = document.getElementById('password_confirmation_fields');
                var inputPasswordFields = document.getElementById('password');
                var inputPasswordConfirmationFields = document.getElementById('password_confirmation');
                if (this.checked) {
                    passwordFields.style.display = 'block';
                    passwordConfirmationFields.style.display = 'block';
                    inputPasswordFields.setAttribute('required', 'required');
                    inputPasswordConfirmationFields.setAttribute('required', 'required');
                } else {
                    passwordFields.style.display = 'none';
                    passwordConfirmationFields.style.display = 'none';
                    inputPasswordFields.removeAttribute('required');
                    inputPasswordConfirmationFields.removeAttribute('required');
                }
            });
        </script>
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.admins.index') }}"
                class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline">
                Back to Drivers List
            </a>
            <button
                class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                type="submit">
                Update Driver
            </button>
        </div>
    </form>

</x-admin-app-layout>
