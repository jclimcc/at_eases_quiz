<x-frontend-user-app-layout>
    <x-slot name="header">
        <h2 class="text-5xl font-semibold leading-tight text-gray-800">
            User Customer {{ now()->format('l j, F') }}
        </h2>
    </x-slot>

    <div class="flex gap-8" x-data="{
        open: false,
        product: {},
        quantity: 1,
        addToBasket: function() {
            var product = { id: this.product.id, name: this.product.product_name, quantity: this.quantity, price: this.product.price, unit: this.product.unit, foc_type: this.product.foc_type, foc_threshold: this.product.foc_threshold, foc_free_amount: this.product.foc_free_amount };
            var products = JSON.parse(window.sessionStorage.getItem('products')) || [];
            var index = products.findIndex(p => p.id === product.id);
    
            if (index !== -1) {
                products[index] = product;
            } else {
                products.push(product);
            }
    
            window.sessionStorage.setItem('products', JSON.stringify(products));
            alert('Added to basket');
    
            this.open = false;
            this.quantity = 1;
            this.product = {};
        }
    }">

        @foreach ($products as $product)
            <div @click="open = true; product = {{ $product }}; product.quantity = 1"
                class="flex flex-col items-center justify-center w-1/2 px-4 bg-white cursor-pointer hover:bg-blue-300">
                <img src="{{ asset('icecube.png') }}" alt="Ice Cube" width="100" height="100">

                <h2>{{ $product->product_name }}</h2>
                <p>RM {{ $product->price }}</p>
            </div>
        @endforeach

        <div x-show="open" @click.away="open = false; product = {}; quantity = 1"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="w-2/5 p-4 text-center bg-white rounded">
                <h2 x-text="product.product_name" class="text-2xl font-bold "></h2>
                <div class="flex items-center justify-center my-4">
                    <button @click="quantity > 1 ? quantity-- : 1"
                        class="px-4 py-2 font-bold text-white bg-red-500 rounded">-</button>
                    <p x-text="quantity" class="mx-4"></p>
                    <button @click="quantity++" class="px-4 py-2 font-bold text-white bg-green-500 rounded">+</button>
                </div>
                <input type="hidden" id="product_id" name="product_id" x-model="product.id">
                <p x-text="'RM ' + product.price * quantity"></p>
                <p x-text="'Remaining ' + product.unit"></p>
                <button @click="addToBasket()" class="px-4 py-2 mt-4 font-bold text-white bg-blue-500 rounded">Add to
                    Basket</button>

                <button @click="open = false; quantity = 1; product = {}"
                    class="px-4 py-2 mt-4 font-bold text-white bg-red-500 rounded">Close</button>
            </div>
        </div>

    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <x-responsive-nav-link :href="route('logout')"
            onclick="event.preventDefault();
                            this.closest('form').submit();">
            {{ __('Log Out') }}
        </x-responsive-nav-link>
    </form>
    <script>
        function addToBasket() {
            var product = {
                id: this.product.id,
                name: this.product.product_name,
                quantity: this.quantity,
                price: this.product.price,
                unit: this.product.unit
            };

            window.sessionStorage.setItem('product', JSON.stringify(product));
        }
    </script>
</x-frontend-user-app-layout>
