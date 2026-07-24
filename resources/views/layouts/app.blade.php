<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SPK Security - Sentra Niaga Bekasi')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Tailwind CSS & Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full text-slate-800 antialiased font-sans flex flex-col" x-data="{ sidebarOpen: false }">

    <div class="min-h-screen flex bg-slate-100">
        
        <!-- Sidebar Navigation -->
        <aside class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col justify-between shadow-2xl"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
            
            <div>
                <!-- Brand Header -->
                <div class="h-20 flex items-center px-6 bg-slate-950 border-b border-slate-800">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-sky-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-sky-500/30 text-white">
                            <i class="fa-solid font-bold fa-shield-halved text-xl"></i>
                        </div>
                        <div>
                            <h1 class="font-extrabold text-base tracking-wide text-white leading-tight">SENTRA NIAGA</h1>
                            <p class="text-[11px] text-sky-400 font-medium tracking-wider uppercase">SPK Security SMART & SWOT</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="mt-6 px-4 space-y-1.5">
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-sky-600 text-white shadow-lg shadow-sky-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-chart-pie w-6 text-base"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('criteria.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('criteria.*') ? 'bg-sky-600 text-white shadow-lg shadow-sky-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-[#0284c7] fa-list-check w-6 text-base"></i>
                        <span>Data Kriteria (SMART)</span>
                    </a>

                    <a href="{{ route('candidates.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('candidates.*') ? 'bg-sky-600 text-white shadow-lg shadow-sky-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-user-shield w-6 text-base"></i>
                        <span>Data Kandidat & Penilaian</span>
                    </a>

                    <a href="{{ route('calculation.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('calculation.*') ? 'bg-sky-600 text-white shadow-lg shadow-sky-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-calculator w-6 text-base"></i>
                        <span>Perhitungan SMART & SWOT</span>
                    </a>

                    <a href="{{ route('reports.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('reports.*') ? 'bg-sky-600 text-white shadow-lg shadow-sky-600/30' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <i class="fa-solid fa-file-invoice w-6 text-base"></i>
                        <span>Laporan Keputusan</span>
                    </a>
                </nav>
            </div>

            <!-- Footer User Profile & Logout -->
            <div class="p-4 border-t border-slate-800 bg-slate-950/60">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-full bg-slate-700 flex items-center justify-center text-sky-400 font-bold border border-slate-600">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name ?? 'User Admin' }}</p>
                            <p class="text-[10px] text-slate-400 uppercase font-semibold">{{ Auth::user()->role ?? 'Admin' }}</p>
                        </div>
                    </div>
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="p-2 text-slate-400 hover:text-red-400 hover:bg-slate-800 rounded-lg transition-colors" title="Keluar">
                            <i class="fa-solid fa-right-from-bracket text-base"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Overlay for mobile sidebar -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false" 
             class="fixed inset-0 z-30 bg-slate-950/60 backdrop-blur-sm lg:hidden"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"></div>

        <!-- Main Content Wrapper -->
        <div class="flex-1 lg:ml-64 flex flex-col min-w-0">
            
            <!-- Top Navbar Header -->
            <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-20 flex items-center justify-between px-6 lg:px-10">
                
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 text-slate-600 hover:text-slate-900 rounded-lg focus:outline-none">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <h2 class="text-lg font-bold text-slate-800 tracking-tight">
                        @yield('header_title', 'Perkantoran Sentra Niaga Bekasi')
                    </h2>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="hidden sm:flex items-center px-3 py-1.5 bg-slate-100 rounded-xl text-xs font-semibold text-slate-600 border border-slate-200">
                        <i class="fa-regular fa-calendar-days text-sky-600 mr-2"></i>
                        <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                    </div>

                    <div class="h-8 w-px bg-slate-200 hidden sm:block"></div>

                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-800 border border-sky-200">
                            <span class="w-2 h-2 mr-1.5 rounded-full bg-sky-500 animate-pulse"></span>
                            Metode SMART & SWOT
                        </span>
                    </div>
                </div>
            </header>

            <!-- Notification Toast / Flash Alerts -->
            @if(session('success'))
            <div class="mx-6 lg:mx-10 mt-6" x-data="{ show: true }" x-show="show" x-transition>
                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 flex items-center justify-between shadow-sm">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-500 text-white flex items-center justify-center">
                            <i class="fa-solid fa-circle-check text-lg"></i>
                        </div>
                        <p class="text-sm font-semibold">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mx-6 lg:mx-10 mt-6" x-data="{ show: true }" x-show="show" x-transition>
                <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-800 flex items-center justify-between shadow-sm">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-xl bg-rose-500 text-white flex items-center justify-center">
                            <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                        </div>
                        <p class="text-sm font-semibold">{{ session('error') }}</p>
                    </div>
                    <button @click="show = false" class="text-rose-500 hover:text-rose-700">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>
            </div>
            @endif

            <!-- Main Body Page Content -->
            <main class="flex-1 p-6 lg:p-10">
                @yield('content')
            </main>

            <!-- Page Footer -->
            <footer class="bg-white border-t border-slate-200 py-4 px-6 lg:px-10 text-center sm:text-left text-xs text-slate-500 flex flex-col sm:flex-row justify-between items-center gap-2">
                <p>&copy; {{ date('Y') }} Perkantoran Sentra Niaga Bekasi. Sistem Pendukung Keputusan Penerimaan Security.</p>
                <p class="font-semibold text-slate-600">Metode SMART & Analisis SWOT</p>
            </footer>
        </div>

    </div>

    @stack('scripts')
</body>
</html>
