<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="KasaLog - Sistem Informasi Distribusi UMKM Antarpulau">
    <title>@yield('title', 'KasaLog') - KasaLog</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface font-sans text-secondary-700 antialiased">

    {{-- Sidebar Overlay (Mobile) --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden"></div>

    {{-- Sidebar --}}
    <x-sidebar :role="$role ?? 'staff'" />

    {{-- Main Content --}}
    <div id="main-content" class="lg:ml-64 min-h-screen transition-all duration-300">
        {{-- Navbar --}}
        <x-navbar :role="$role ?? 'staff'" :pageTitle="$pageTitle ?? 'Dashboard'" />

        {{-- Breadcrumb --}}
        <div class="px-4 sm:px-6 lg:px-8 pt-4">
            @yield('breadcrumb')
        </div>

        {{-- Page Content --}}
        <main class="px-4 sm:px-6 lg:px-8 py-6 page-content">
            @yield('content')
        </main>
    </div>

    {{-- Toast Container --}}
    <div class="toast-container"></div>

    @yield('scripts')
</body>
</html>
