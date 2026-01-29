<nav class="bg-yellow-500 p-4">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <!-- Logo -->
        <a href="/index" class="flex items-center">
            <img src="{{ asset('images/logo5_klein.png') }}" alt="Barroc Intens Logo" class="h-8 mr-2"> <!-- Voeg het logo toe -->
            <span class="text-white text-2xl font-semibold">Barroc<span class="text-black">Intens.</span></span>
        </a>
{{--        @auth--}}
{{--            @if(Auth::user()->name === 'Admin')--}}
                <div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full border-gray-300 rounded p-2"
                           placeholder="Search...">
                </div>
{{--            @endif--}}
{{--        @endauth--}}

        <!-- Navigation Links -->
        <div class="space-x-4">
            @guest
                <!-- Link voor niet-ingelogde gebruikers -->
                <a href="{{ route('login') }}" class="text-white">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-white">Register</a>
                @endif
            @else
                <!-- Links voor ingelogde gebruikers -->
                <a href="{{ route('index') }}" class="text-white">Home</a>

                <a href="{{ url('/customers') }}" class="text-white">Customers</a>

                <a href="{{ route('issues.index') }}" class="text-white">Issues</a>

                <a href="{{ route('orders.index') }}" class="text-white">Orders</a>

                <a href="{{ route('roles.assign') }}" class="text-white">assign roles</a>

                <!-- Dit moet later specifiek voor de juiste users worden -->
                <a href="{{ route('dashboard') }}" class="text-white">Dashboard</a>

                <a href="{{ route('products.index') }}" class="text-white">Machines</a>

                <a href="{{ route('leases.index') }}" class="text-white">Leases</a>

                <a href="{{ route('contact') }}" class="text-white">Contact</a>

                <a href="{{ route('audit.index') }}" class="text-white">auditpage</a>

                <a href="{{ route('sales-funnel.index') }}" class="text-white">
                    Sales Funnel
                </a>

                <!-- Logout Form -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-white">Logout</button>
                </form>
            @endguest
        </div>
    </div>
</nav>
