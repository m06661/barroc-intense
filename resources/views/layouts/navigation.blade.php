<nav class="bg-yellow-500 px-6 py-4">
    <div class="max-w-7xl mx-auto flex items-center justify-between">

        <!-- Logo -->
        <a href="/index" class="flex items-center gap-2">
            <img src="{{ asset('images/logo5_klein.png') }}" alt="Barroc Intens Logo" class="h-8">
            <span class="text-white text-2xl font-semibold">
                Barroc<span class="text-black">Intens.</span>
            </span>
        </a>

        <!-- Search bar (alleen ingelogd) -->
        @auth
            <div class="flex-1 flex justify-center">
                <div class="relative w-full max-w-md">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                        <!-- Search icon -->
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z"/>
                        </svg>
                    </span>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Zoeken..."
                        class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300
                               shadow-sm focus:outline-none focus:ring-2
                               focus:ring-yellow-400 focus:border-yellow-400"
                    >
                </div>
            </div>
        @endauth

        <!-- Navigation -->
        <div class="flex items-center space-x-6 text-white">

            @guest
                <a href="{{ route('login') }}">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @else
                <a href="{{ route('index') }}">Home</a>
                <a href="{{ url('/customers') }}">Customers</a>
                <a href="{{ route('orders.index') }}">Orders</a>
                <a href="{{ route('issues.index') }}">Issues</a>

                <!-- Dropdown -->
                <div class="relative group">
                    <button class="flex items-center gap-1">
                        Meer
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div class="absolute right-0 mt-2 w-48 bg-white text-black rounded-lg shadow-lg
                                opacity-0 invisible group-hover:opacity-100 group-hover:visible
                                transition-all duration-200 z-50">

                        <a href="{{ route('products.index') }}" class="block px-4 py-2 hover:bg-gray-100">Machines</a>
                        <a href="{{ route('leases.index') }}" class="block px-4 py-2 hover:bg-gray-100">Leases</a>
                        <a href="{{ route('sales-funnel.index') }}" class="block px-4 py-2 hover:bg-gray-100">Sales Funnel</a>
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a>
                        <a href="{{ route('audit.index') }}" class="block px-4 py-2 hover:bg-gray-100">Audit</a>
                        <a href="{{ route('roles.assign') }}" class="block px-4 py-2 hover:bg-gray-100">Assign Roles</a>
                        <a href="{{ route('contact') }}" class="block px-4 py-2 hover:bg-gray-100">Contact</a>
                    </div>
                </div>
                <a href="{{ route('machines.index') }}" class="text-white">Machines</a>
                <!-- Feedback Link -->
                <a href="{{ route('feedback.index') }}" class="text-white hover:text-gray-200 transition">Feedback</a>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @endguest
        </div>
    </div>
</nav>
