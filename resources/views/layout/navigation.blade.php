<nav class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('admin.dashboard') : route('karyawan.dashboard')) : route('login') }}">
                        <!-- Ganti dengan logo atau nama aplikasi -->
                        <span class="text-lg font-semibold text-gray-700">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.dashboard') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                            Admin Dashboard
                        </a>
                        <a href="{{ route('admin.karyawan.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.karyawan.*') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                            Kelola Karyawan
                        </a>
                        <a href="{{ route('admin.absensi.rekap') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.absensi.rekap') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                            Rekap Absensi
                        </a>
                         <a href="{{ route('admin.gaji.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.gaji.*') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                            Kelola Gaji
                        </a>
                    @elseif(auth()->check() && auth()->user()->isKaryawan())
                        <a href="{{ route('karyawan.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('karyawan.dashboard') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                            Dashboard
                        </a>
                        <a href="{{ route('karyawan.riwayat.absensi') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('karyawan.riwayat.absensi') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                            Riwayat Absensi
                        </a>
                        <a href="{{ route('karyawan.invoice.gaji') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('karyawan.invoice.gaji') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 transition duration-150 ease-in-out">
                            Invoice Gaji
                        </a>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown (Sederhana tanpa JS) -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @if(auth()->check())
                    <div class="text-gray-700 mr-3">{{ auth()->user()->name }}</div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Log Out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900">Log in</a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-600 hover:text-gray-900">Register</a>
                    @endif
                @endif
            </div>

            <!-- Hamburger (untuk mobile, bisa disederhanakan atau dihilangkan jika tidak pakai JS) -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Responsive Navigation Menu (perlu JS untuk toggle, bisa di-skip/disederhanakan) -->
</nav>