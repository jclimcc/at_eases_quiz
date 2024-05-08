<x-admin-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            View Product {{ $product_name }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="relative px-4 py-3 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('admin.products.details.store', $product_id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="product_id" value="{{ $product_id }}">

        <div class="mb-4">
            <label for="customer_name" class="block mb-2 text-sm font-bold text-gray-700">Customer Name</label>
            <input type="text" id="customer_name" name="customer_name"
                class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
            <input type="hidden" id="user_id" name="user_id">
        </div>

        <!-- Add other form fields here -->
        <div id="additional_fields" style="display: none;">
            <!-- Add other form fields here -->
            <div class="mb-4">
                <label for="unit" class="block mb-2 text-sm font-bold text-gray-700">Unit</label>
                <input type="number" id="unit" name="unit"
                    class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="price" class="block mb-2 text-sm font-bold text-gray-700">Price</label>
                <input type="number" id="price" name="price"
                    class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-4">
                <label for="type" class="block mb-2 text-sm font-bold text-gray-700">FOC Type</label>
                <select id="type" name="type"
                    class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                    <option value="quantity">Quantity</option>
                    <option value="order_units">Order Units</option>
                </select>
            </div>

            <div id="remarks_field" class="mb-4">
                <label for="remarks" class="block mb-2 text-sm font-bold text-gray-700">Remarks</label>
                <span id="remarks" name="remarks"
                    class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline"
                    readonly></span>
            </div>
            <div id="threshold_field" class="mb-4">
                <label for="threshold" class="block mb-2 text-sm font-bold text-gray-700">Threshold</label>
                <input type="number" id="threshold" name="threshold"
                    class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
            </div>

            <div id="free_amount_field" class="mb-4" style="display: none;">
                <label for="free_amount" class="block mb-2 text-sm font-bold text-gray-700">Free Amount</label>
                <input type="number" id="free_amount" name="free_amount"
                    class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
            </div>

            <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Submit
                Price</button>
        </div>
    </form>
    <div x-data="{ open: false, productPrice: {} }">
        <table class="min-w-full divide-y divide-gray-200 shadow sm:rounded-lg">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">User Name
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Price
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Unit</th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">FOC Type
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">FOC
                        Threshold
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">FOC Free
                        Unit
                    </th>

                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Action
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">

                @forelse ($productPrices as $productPrice)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $productPrice->user_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $productPrice->price }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $productPrice->unit }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ ucwords(str_replace('_', ' ', $productPrice->type)) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $productPrice->threshold }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $productPrice->type == 'quantity' ? 'NA' : $productPrice->free_amount }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <!-- Add action buttons here -->
                            <button
                                @click="open = true, productPrice = { username: '{{ $productPrice->user_name }}',user_id: '{{ $productPrice->user_id }}', price: '{{ $productPrice->price }}', unit: '{{ $productPrice->unit }}', type: '{{ $productPrice->type }}', threshold: '{{ $productPrice->threshold }}', free_amount: '{{ $productPrice->free_amount }}' }"
                                class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Edit</button>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Empty</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div x-show="open" class="fixed inset-0 z-10 overflow-y-auto" style="display: none;">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div
                    class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">

                        <!-- Add form fields here -->
                        <form action="{{ route('admin.products.details.edit', $product_id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="product_id" value="{{ $product_id }}">
                            <input type="hidden" x-bind:value="productPrice.user_id" name="muser_id">

                            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="mb-4">
                                    <label for="username"
                                        class="block text-sm font-medium text-gray-700">Username</label>
                                    <input type="text" x-bind:value="productPrice.username" id="username"
                                        name="musername"
                                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                                </div>

                                <div class="mb-4">
                                    <label for="price"
                                        class="block text-sm font-medium text-gray-700">Price</label>
                                    <input type="number" x-bind:value="productPrice.price" id="price"
                                        name="mprice"
                                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                                </div>

                                <div class="mb-4">
                                    <label for="unit" class="block text-sm font-medium text-gray-700">Unit</label>
                                    <input type="number" x-bind:value="productPrice.unit" id="unit"
                                        name="munit"
                                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                                </div>

                                <div class="mb-4">
                                    <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                                    <select x-bind:value="productPrice.type" id="type" name="mtype"
                                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                                        <option value="quantity" x-bind:selected="productPrice.type === 'quantity'">
                                            Quantity</option>
                                        <option value="order_units"
                                            x-bind:selected="productPrice.type === 'order_units'">Order Units</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="threshold"
                                        class="block text-sm font-medium text-gray-700">Threshold</label>
                                    <input type="number" x-bind:value="productPrice.threshold" id="threshold"
                                        name="mthreshold"
                                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                                </div>

                                <div class="mb-4">
                                    <label for="free_amount" class="block text-sm font-medium text-gray-700">Free
                                        Amount</label>
                                    <input type="number" x-bind:value="productPrice.free_amount" id="free_amount"
                                        name="mfree_amount"
                                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none focus:shadow-outline">
                                </div>
                            </div>
                            <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit"
                                    class="px-4 py-2 font-bold text-white bg-green-500 rounded hover:bg-green-700">Submit</button>
                                <button type="button" @click="open = false"
                                    class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="fixed bottom-0 right-0 mb-4 mr-4">
        <a href="{{ route('admin.products.index') }}"
            class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline">
            Back to Products List
        </a>
    </div>

    @push('scripts')
        <script src="{{ asset('js/custom.js') }}"></script>
    @endpush
</x-admin-app-layout>
