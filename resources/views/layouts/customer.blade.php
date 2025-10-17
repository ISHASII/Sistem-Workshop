<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - {{ config('app.name') }}</title>
    @if (app()->environment('local'))
        {{-- Use Vite dev server in local environment --}}
        @vite(['resources/css/app.css','resources/js/app.js'])
    @else
        {{-- Use built assets in production/other envs --}}
        @vite(['resources/css/app.css','resources/js/app.js'])
    @endif
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">
    <nav class="bg-white/80 backdrop-blur-xl border-b border-slate-200/50 shadow-lg shadow-slate-900/5 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-2 sm:px-4">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center h-auto md:h-16">
                <!-- Left side - Logo and Navigation -->
                <div class="flex items-center space-x-8">
                    <!-- Logo -->
                    <a href="{{ route('customer.dashboard') }}" class="flex items-center">
                        <img src="{{ asset('image/logo-ahm.png') }}" alt="{{ config('app.name') }} logo" class="w-16 h-16 md:w-20 md:h-20 lg:w-24 lg:h-24 object-contain mr-4">
                        <div class="hidden md:flex flex-col leading-tight">
                            <span class="text-lg font-semibold text-slate-800">Sistem Workshop</span>
                        </div>
                    </a>

                    <!-- Desktop Navigation (only Dashboard + Job Order) -->
                    <div class="hidden lg:flex items-center space-x-1">
                        <a href="{{ route('customer.dashboard') }}" class="nav-link group flex items-center px-4 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('customer.dashboard') ? 'bg-red-100 text-red-700 font-bold' : 'text-slate-600 hover:text-red-600 hover:bg-red-50' }}">
                            <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('customer.joborder.index') }}" class="nav-link group flex items-center px-4 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('customer.joborder.*') ? 'bg-red-100 text-red-700 font-bold' : 'text-slate-600 hover:text-red-600 hover:bg-red-50' }}">
                            <svg class="w-4 h-4 mr-2 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Job Order
                        </a>
                    </div>
                </div>

                <!-- Right side - Profile dropdown and mobile menu -->
                <div class="flex items-center space-x-4">
                    <!-- Profile dropdown (desktop) -->
                    <div class="hidden md:block relative group">
                        <button class="nav-dropdown-button flex items-center px-4 py-2 text-sm font-medium text-slate-600 hover:text-red-600 rounded-xl hover:bg-red-50 transition-all duration-200">
                            <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-red-600 rounded-lg flex items-center justify-center">
                                <span class="text-white text-sm font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                            <span class="ml-2 text-sm font-medium">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 ml-1 group-hover:rotate-180 transition-transform duration-200 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="nav-dropdown absolute right-0 mt-2 w-56 bg-white/95 backdrop-blur-xl rounded-2xl shadow-xl shadow-slate-900/10 border border-slate-200/50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                            <div class="p-2">
                                <a href="{{ route('customer.profile.edit') }}" class="flex items-center px-4 py-3 text-sm text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 group">
                                    <div class="w-6 h-6 bg-slate-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-3 h-3 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.58 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium">Profile</div>
                                        <div class="text-xs text-slate-400">Ubah username & password</div>
                                    </div>
                                </a>

                                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                                    @csrf
                                    <button type="submit" class="flex items-center px-4 py-3 text-sm text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200">
                                        <div class="w-6 h-6 bg-red-50 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-3 h-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium text-red-600">Logout</div>
                                            <div class="text-xs text-slate-400">Keluar dari akun</div>
                                        </div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="lg:hidden">
                        <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-600 hover:text-red-600 hover:bg-red-50 focus:outline-none transition-all duration-200" aria-expanded="false">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="lg:hidden hidden border-t border-slate-200/50 bg-white/95 backdrop-blur-xl">
            <div class="px-4 pt-4 pb-6 space-y-2">
                <!-- User info mobile -->
                <div class="flex items-center space-x-3 bg-slate-50 rounded-xl px-4 py-3 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center">
                        <span class="text-white font-semibold">
                            {{ substr(auth()->user()->name ?? auth()->user()->username, 0, 1) }}
                        </span>
                    </div>
                    <div>
                        <div class="font-medium text-slate-800">{{ auth()->user()->name ?? auth()->user()->username }}</div>
                        <div class="text-sm text-slate-500">Customer</div>
                    </div>
                </div>

                <!-- Navigation links mobile (only Dashboard + Job Order) -->
                <a href="{{ route('customer.dashboard') }}" class="flex items-center px-4 py-3 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="m8 5l4-4l4 4"></path>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('customer.joborder.index') }}" class="flex items-center px-4 py-3 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Job Order
                </a>

                <a href="{{ Route::has('customer.kategori.index') ? route('customer.kategori.index') : '#' }}" class="flex items-center px-4 py-3 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    Kategori
                </a>

                <a href="{{ Route::has('customer.satuan.index') ? route('customer.satuan.index') : '#' }}" class="flex items-center px-4 py-3 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Satuan
                </a>

                <!-- Logout mobile -->
                <form method="POST" action="{{ route('logout') }}" class="mt-6 pt-4 border-t border-slate-200/50">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-medium rounded-xl hover:from-red-600 hover:to-red-700 shadow-lg shadow-red-500/25 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const btn = document.getElementById('mobile-menu-button');
                const menu = document.getElementById('mobile-menu');

                if (btn) {
                    btn.addEventListener('click', function () {
                        menu.classList.toggle('hidden');
                    });
                }

                // Close mobile menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (!btn.contains(event.target) && !menu.contains(event.target)) {
                        menu.classList.add('hidden');
                    }
                });

                // Handle dropdown functionality
                const dropdownButtons = document.querySelectorAll('.nav-dropdown-button');
                dropdownButtons.forEach(button => {
                    const dropdown = button.nextElementSibling;

                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                    });
                });
            });
        </script>
    </nav>

    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4">
            @yield('content')
        </div>
    </main>

    <style>
        .nav-dropdown:hover .nav-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        /* Hide native browser password reveal/clear controls so only our custom toggle is visible */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }
        input[type="password"]::-webkit-password-toggle-button,
        input[type="password"]::-webkit-textfield-decoration-container,
        input[type="password"]::-webkit-textfield-decoration-button,
        input[type="password"]::-webkit-search-cancel-button {
            display: none !important;
        }
        input[type="password"] {
            -webkit-appearance: none;
            appearance: none;
        }
    </style>

    @stack('scripts')
</body>
</html>
