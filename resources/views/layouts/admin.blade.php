<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen" @if(session('success')) data-flash-success="{{ session('success') }}" @endif @if(session('error')) data-flash-error="{{ session('error') }}" @endif>
    <nav class="bg-white/80 backdrop-blur-xl border-b border-slate-200/50 shadow-lg shadow-slate-900/5 sticky top-0 z-50">
        <div class="w-full pr-4 sm:pr-6 lg:pr-8" style="padding-left: 0 !important; margin-left: 0 !important; margin-right: 0 !important;">
            <div class="flex justify-between items-center h-16">
                <!-- Left side - Logo and Navigation -->
                <div class="flex items-center space-x-8" style="margin-left: 0 !important; padding-left: 35px !important;">
                    <!-- Logo -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center" style="display: flex !important; align-items: center !important; gap: 6px !important; margin-right: 24px !important; margin-left: 0 !important; padding-left: 0 !important;">
                        <img src="{{ asset('image/logo-ahm.png') }}" alt="{{ config('app.name') }} logo" class="w-16 h-16 object-contain" style="width: 64px !important; height: 64px !important;">
                        <span class="text-base font-semibold text-slate-800" style="font-size: 16px !important; font-weight: 600 !important; line-height: 1.2 !important; white-space: nowrap !important;">Sistem Workshop</span>
                    </a>

                    <!-- Desktop Navigation -->
                    <div class="hidden lg:flex items-center space-x-1">
                        <!-- Dashboard -->
                        <a href="{{ route('admin.dashboard') }}" class="nav-link group flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-red-100 text-red-700 font-bold' : 'text-slate-600 hover:text-red-600 hover:bg-red-50' }}">
                            <svg class="w-4 h-4 mr-1.5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            Dashboard
                        </a>

                        <!-- Manajemen Akun -->
                        <a href="{{ route('admin.users.index') }}" class="nav-link group flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-red-100 text-red-700 font-bold' : 'text-slate-600 hover:text-red-600 hover:bg-red-50' }}">
                            <svg class="w-4 h-4 mr-1.5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 10-8 0v4M5 21h14a2 2 0 002-2V9H3v10a2 2 0 002 2z"></path>
                            </svg>
                            Akun
                        </a>

                        <!-- Master Data Dropdown -->
                        <div class="relative group">
                            <button class="nav-dropdown-button flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.kategori.*') || request()->routeIs('admin.satuan.*') ? 'bg-red-100 text-red-700 font-bold' : 'text-slate-600 hover:text-red-600 hover:bg-red-50' }}">
                                <svg class="w-4 h-4 mr-1.5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                                </svg>
                                Master Data
                                <svg class="w-3 h-3 ml-1 group-hover:rotate-180 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9l-7 7l-7-7"></path>
                                </svg>
                            </button>

                            <div class="nav-dropdown absolute left-0 mt-2 w-48 bg-white/95 backdrop-blur-xl rounded-xl shadow-xl shadow-slate-900/10 border border-slate-200/50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                                <div class="p-1.5">
                                    @if(Route::has('admin.kategori.index'))
                                    <a href="{{ route('admin.kategori.index') }}" class="flex items-center px-3 py-2.5 text-sm rounded-lg transition-all duration-200 {{ request()->routeIs('admin.kategori.*') ? 'bg-violet-50 text-violet-700' : 'text-slate-600 hover:text-violet-600 hover:bg-violet-50' }}">
                                        <div class="w-7 h-7 rounded-lg flex items-center justify-center mr-2.5 {{ request()->routeIs('admin.kategori.*') ? 'bg-violet-200' : 'bg-violet-100' }}">
                                            <svg class="w-3.5 h-3.5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                            </svg>
                                        </div>
                                        <div class="font-medium">Kategori</div>
                                    </a>
                                    @endif

                                    @if(Route::has('admin.satuan.index'))
                                    <a href="{{ route('admin.satuan.index') }}" class="flex items-center px-3 py-2.5 text-sm rounded-lg transition-all duration-200 {{ request()->routeIs('admin.satuan.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:text-emerald-600 hover:bg-emerald-50' }}">
                                        <div class="w-7 h-7 rounded-lg flex items-center justify-center mr-2.5 {{ request()->routeIs('admin.satuan.*') ? 'bg-emerald-200' : 'bg-emerald-100' }}">
                                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                            </svg>
                                        </div>
                                        <div class="font-medium">Satuan</div>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Material Dropdown -->
                        <div class="relative group">
                            <button class="nav-dropdown-button flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.materials.*') || request()->routeIs('admin.material-movements.*') ? 'bg-red-100 text-red-700 font-bold' : 'text-slate-600 hover:text-red-600 hover:bg-red-50' }}">
                                <svg class="w-4 h-4 mr-1.5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Material
                                <svg class="w-3 h-3 ml-1 group-hover:rotate-180 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9l-7 7l-7-7"></path>
                                </svg>
                            </button>

                            <div class="nav-dropdown absolute left-0 mt-2 w-52 bg-white/95 backdrop-blur-xl rounded-xl shadow-xl shadow-slate-900/10 border border-slate-200/50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                                <div class="p-1.5">
                                    <a href="{{ route('admin.materials.index') }}" class="flex items-center px-3 py-2.5 text-sm rounded-lg transition-all duration-200 {{ request()->routeIs('admin.materials.*') ? 'bg-purple-50 text-purple-700' : 'text-slate-600 hover:text-purple-600 hover:bg-purple-50' }}">
                                        <div class="w-7 h-7 rounded-lg flex items-center justify-center mr-2.5 {{ request()->routeIs('admin.materials.*') ? 'bg-purple-200' : 'bg-purple-100' }}">
                                            <svg class="w-3.5 h-3.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                        <div class="font-medium">Data Material</div>
                                    </a>

                                    <a href="{{ route('admin.material-movements.index') }}" class="flex items-center px-3 py-2.5 text-sm rounded-lg transition-all duration-200 {{ request()->routeIs('admin.material-movements.*') ? 'bg-green-50 text-green-700' : 'text-slate-600 hover:text-green-600 hover:bg-green-50' }}">
                                        <div class="w-7 h-7 rounded-lg flex items-center justify-center mr-2.5 {{ request()->routeIs('admin.material-movements.*') ? 'bg-green-200' : 'bg-green-100' }}">
                                            <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                            </svg>
                                        </div>
                                        <div class="font-medium">Perpindahan Stok</div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Manpower + Performance Dropdown -->
                        <div class="relative group">
                            <button class="nav-dropdown-button flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.manpower.*') || request()->routeIs('admin.performance.*') ? 'bg-red-100 text-red-700 font-bold' : 'text-slate-600 hover:text-red-600 hover:bg-red-50' }}">
                                <svg class="w-4 h-4 mr-1.5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Manpower
                                <svg class="w-3 h-3 ml-1 group-hover:rotate-180 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9l-7 7l-7-7"></path>
                                </svg>
                            </button>

                            <div class="nav-dropdown absolute left-0 mt-2 w-48 bg-white/95 backdrop-blur-xl rounded-xl shadow-xl shadow-slate-900/10 border border-slate-200/50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                                <div class="p-1.5">
                                    <a href="{{ route('admin.manpower.index') }}" class="flex items-center px-3 py-2.5 text-sm rounded-lg transition-all duration-200 {{ request()->routeIs('admin.manpower.*') ? 'bg-red-50 text-red-700' : 'text-slate-600 hover:text-red-600 hover:bg-red-50' }}">
                                        <div class="w-7 h-7 rounded-lg flex items-center justify-center mr-2.5 {{ request()->routeIs('admin.manpower.*') ? 'bg-red-200' : 'bg-red-100' }}">
                                            <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.58 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <div class="font-medium">Data Manpower</div>
                                    </a>

                                    <a href="{{ route('admin.performance.index') }}" class="flex items-center px-3 py-2.5 text-sm rounded-lg transition-all duration-200 {{ request()->routeIs('admin.performance.*') ? 'bg-red-50 text-red-700' : 'text-slate-600 hover:text-red-600 hover:bg-red-50' }}">
                                        <div class="w-7 h-7 rounded-lg flex items-center justify-center mr-2.5 {{ request()->routeIs('admin.performance.*') ? 'bg-red-200' : 'bg-red-100' }}">
                                            <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                            </svg>
                                        </div>
                                        <div class="font-medium">Performance</div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Job Order -->
                        <a href="{{ route('admin.joborder.index') }}" class="nav-link group flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.joborder.*') ? 'bg-red-100 text-red-700 font-bold' : 'text-slate-600 hover:text-red-600 hover:bg-red-50' }}">
                            <svg class="w-4 h-4 mr-1.5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Job Order
                        </a>

                    </div>
                </div>

                <!-- Right side - Notifications, Profile dropdown and mobile menu -->
                <div class="flex items-center space-x-4">
                    <!-- Notifications (admin only) -->
                    @if(auth()->user()->role === 'admin')
                        <div class="hidden md:block relative">
                            <a href="{{ route('admin.notifications.index') }}" class="relative flex items-center justify-center w-10 h-10 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 group">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 group-hover:scale-110 transition-transform duration-200">
                                    <path d="M4.214 3.227a.75.75 0 0 0-1.156-.955 8.97 8.97 0 0 0-1.856 3.825.75.75 0 0 0 1.466.316 7.47 7.47 0 0 1 1.546-3.186ZM16.942 2.272a.75.75 0 0 0-1.157.955 7.47 7.47 0 0 1 1.547 3.186.75.75 0 0 0 1.466-.316 8.971 8.971 0 0 0-1.856-3.825Z" />
                                    <path fill-rule="evenodd" d="M10 2a6 6 0 0 0-6 6c0 1.887-.454 3.665-1.257 5.234a.75.75 0 0 0 .515 1.076 32.91 32.91 0 0 0 3.256.508 3.5 3.5 0 0 0 6.972 0 32.903 32.903 0 0 0 3.256-.508.75.75 0 0 0 .515-1.076A11.448 11.448 0 0 1 16 8a6 6 0 0 0-6-6Zm0 14.5a2 2 0 0 1-1.95-1.557 33.54 33.54 0 0 0 3.9 0A2 2 0 0 1 10 16.5Z" clip-rule="evenodd" />
                                </svg>
                                <!-- Notification count badge -->
                                @php
                                    $unreadCount = auth()->user()->unreadNotificationsCount();
                                @endphp
                                <!-- Notification count badge -->
                                @if($unreadCount > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-medium">
                                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                    </span>
                                @endif
                            </a>
                        </div>
                    @endif

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
                                <a href="{{ route('admin.profile.edit') }}" class="flex items-center px-4 py-3 text-sm text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 group">
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
                <!-- (mobile user info moved below with logout) -->

                <!-- Navigation links mobile -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-red-50 text-red-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Dashboard
                </a>

                <!-- Notifications mobile -->
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.notifications.index') }}" class="flex items-center px-4 py-3 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.notifications.*') ? 'bg-red-50 text-red-700' : '' }}">
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-3">
                                <path d="M4.214 3.227a.75.75 0 0 0-1.156-.955 8.97 8.97 0 0 0-1.856 3.825.75.75 0 0 0 1.466.316 7.47 7.47 0 0 1 1.546-3.186ZM16.942 2.272a.75.75 0 0 0-1.157.955 7.47 7.47 0 0 1 1.547 3.186.75.75 0 0 0 1.466-.316 8.971 8.971 0 0 0-1.856-3.825Z" />
                                <path fill-rule="evenodd" d="M10 2a6 6 0 0 0-6 6c0 1.887-.454 3.665-1.257 5.234a.75.75 0 0 0 .515 1.076 32.91 32.91 0 0 0 3.256.508 3.5 3.5 0 0 0 6.972 0 32.903 32.903 0 0 0 3.256-.508.75.75 0 0 0 .515-1.076A11.448 11.448 0 0 1 16 8a6 6 0 0 0-6-6Zm0 14.5a2 2 0 0 1-1.95-1.557 33.54 33.54 0 0 0 3.9 0A2 2 0 0 1 10 16.5Z" clip-rule="evenodd" />
                            </svg>
                            @php
                                $mobileUnreadCount = auth()->user()->unreadNotificationsCount();
                            @endphp
                            @if($mobileUnreadCount > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center font-medium">
                                    {{ $mobileUnreadCount > 9 ? '9+' : $mobileUnreadCount }}
                                </span>
                            @endif
                        </div>
                        Notifications
                        @if($mobileUnreadCount > 0)
                            <span class="ml-auto bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full font-medium">
                                {{ $mobileUnreadCount }}
                            </span>
                        @endif
                    </a>
                @endif

                <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-red-50 text-red-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 10-8 0v4M5 21h14a2 2 0 002-2V9H3v10a2 2 0 002 2z"></path>
                    </svg>
                    Manajemen Akun
                </a>

                <!-- Master Data Dropdown -->
                <div class="space-y-1">
                    <div class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wide">Master Data</div>
                    @if(Route::has('admin.kategori.index'))
                    <a href="{{ route('admin.kategori.index') }}" class="flex items-center px-4 py-3 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 ml-4">
                        <div class="w-6 h-6 bg-violet-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-3 h-3 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </div>
                        Kategori
                    </a>
                    @endif

                    @if(Route::has('admin.satuan.index'))
                    <a href="{{ route('admin.satuan.index') }}" class="flex items-center px-4 py-3 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 ml-4">
                        <div class="w-6 h-6 bg-emerald-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                            </svg>
                        </div>
                        Satuan
                    </a>
                    @endif
                </div>

                <div class="space-y-1">
                    <div class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wide">Manpower</div>
                    <a href="{{ route('admin.manpower.index') }}" class="flex items-center px-4 py-3 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 ml-4 {{ request()->routeIs('admin.manpower.*') ? 'bg-red-50 text-red-700' : '' }}">
                        <div class="w-6 h-6 bg-red-100 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.manpower.*') ? 'bg-red-200' : 'bg-red-100' }}">
                            <svg class="w-3 h-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.58 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        Data Manpower
                    </a>

                    <a href="{{ route('admin.performance.index') }}" class="flex items-center px-4 py-3 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 ml-4 {{ request()->routeIs('admin.performance.*') ? 'bg-red-50 text-red-700' : '' }}">
                        <div class="w-6 h-6 bg-red-100 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.performance.*') ? 'bg-red-200' : 'bg-red-100' }}">
                            <svg class="w-3 h-3 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        Performance
                    </a>
                </div>

                <div class="space-y-1">
                    <div class="px-4 py-2 text-xs font-semibold text-slate-400 uppercase tracking-wide">Material</div>
                    <a href="{{ route('admin.materials.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 ml-4 {{ request()->routeIs('admin.materials.*') ? 'bg-purple-50 text-purple-700' : 'text-slate-600 hover:text-purple-600 hover:bg-purple-50' }}">
                        <div class="w-6 h-6 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.materials.*') ? 'bg-purple-200' : 'bg-purple-100' }}">
                            <svg class="w-3 h-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        Data Material
                    </a>

                    <a href="{{ route('admin.material-movements.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 ml-4 {{ request()->routeIs('admin.material-movements.*') ? 'bg-green-50 text-green-700' : 'text-slate-600 hover:text-green-600 hover:bg-green-50' }}">
                        <div class="w-6 h-6 rounded-lg flex items-center justify-center mr-3 {{ request()->routeIs('admin.material-movements.*') ? 'bg-green-200' : 'bg-green-100' }}">
                            <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                        </div>
                        Perpindahan Stok
                    </a>
                </div>

                <!-- Job Order -->
                <a href="{{ route('admin.joborder.index') }}" class="flex items-center px-4 py-3 text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.joborder.*') ? 'bg-red-50 text-red-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Job Order
                </a>                <!-- Mobile user info and logout -->
                <div class="px-4 pt-4 pb-6">
                    <div class="flex items-center space-x-3 bg-slate-50 rounded-xl px-4 py-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center">
                            <span class="text-white font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-slate-800">{{ auth()->user()->name }}</div>
                            <div class="text-sm text-slate-500">Administrator</div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-3 py-2 bg-red-50 text-red-700 rounded-md text-sm hover:bg-red-100">Logout</button>
                        </form>
                    </div>

                    <!-- Navigation links mobile -->
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

    <!-- Centralized SweetAlert2 and toast handling -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-container .swal2-actions .swal2-confirm { background-color: #d33 !important; color: #fff !important; }
        .swal2-container .swal2-actions .swal2-cancel { background-color: #e2e8f0 !important; color: #1f2937 !important; }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Global toast helper for Laravel session flashes
            if (window.Swal) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3500,
                    timerProgressBar: true,
                });

                // Read flash messages inserted into DOM as data attributes
                const flashSuccess = document.body.getAttribute('data-flash-success');
                const flashError = document.body.getAttribute('data-flash-error');
                if (flashSuccess) { Toast.fire({ icon: 'success', title: flashSuccess }); }
                if (flashError) { Toast.fire({ icon: 'error', title: flashError }); }
            }

            // Delegate: attach confirm-cancel behavior to any element with data-swal-cancel
            document.querySelectorAll('[data-swal-cancel]').forEach(function(el){
                el.addEventListener('click', function(e){
                    const href = el.getAttribute('href') || el.dataset.href;
                    e.preventDefault();
                    Swal.fire({
                        title: el.dataset && el.dataset.swalTitle || el.getAttribute('data-swal-title') || 'Batalkan perubahan?',
                        text: el.dataset && el.dataset.swalText || el.getAttribute('data-swal-text') || 'Perubahan yang belum disimpan akan hilang.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: el.dataset && el.dataset.swalConfirm || el.getAttribute('data-swal-confirm') || 'Ya, batal',
                        cancelButtonText: el.dataset && el.dataset.swalCancelText || el.getAttribute('data-swal-cancel-text') || 'Kembali'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if(href){ window.location.href = href; }
                        }
                    });
                });
            });

            // Delegate: confirm deletion for any form with class "swal-delete"
            document.addEventListener('submit', function(e) {
                const form = e.target;
                if (!form || !form.matches || !form.matches('form.swal-delete')) return;
                e.preventDefault();
                const title = form.getAttribute('data-swal-title') || (form.dataset && form.dataset.swalTitle) || 'Yakin ingin menghapus?';
                const text = form.getAttribute('data-swal-text') || (form.dataset && form.dataset.swalText) || 'Data akan dihapus dan tidak dapat dikembalikan.';
                const confirmText = form.getAttribute('data-swal-confirm') || (form.dataset && form.dataset.swalConfirm) || 'Ya, hapus!';
                const cancelText = form.getAttribute('data-swal-cancel-text') || (form.dataset && form.dataset.swalCancelText) || 'Batal';

                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: confirmText,
                    cancelButtonText: cancelText
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
