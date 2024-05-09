<x-frontend-driver-app-layout>
    <x-slot name="header">
        <h2 class="text-5xl font-semibold leading-tight text-gray-800">
            Customer List {{ now()->format('l j, F') }}
        </h2>
    </x-slot>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <x-responsive-nav-link :href="route('logout')"
            onclick="event.preventDefault();
                            this.closest('form').submit();">
            {{ __('Log Out') }}
        </x-responsive-nav-link>
    </form>




</x-frontend-driver-app-layout>
