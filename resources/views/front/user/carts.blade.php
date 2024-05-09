<x-frontend-user-app-layout>
    <x-slot name="header">
        <h2 class="text-5xl font-semibold leading-tight text-gray-800">
            Cart Order Customer {{ now()->format('l j, F') }}
        </h2>
    </x-slot>

    <div class="flex gap-8">

        @foreach ($products as $product)
            <div class="flex flex-col items-center justify-center w-1/2 px-4 bg-white cursor-pointer hover:bg-blue-300">
                <img src="{{ asset('icecube.png') }}" alt="Ice Cube" width="100" height="100">

                <h2>{{ $product->product_name }}</h2>
                <p>RM {{ $product->price }}</p>
            </div>
        @endforeach

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
