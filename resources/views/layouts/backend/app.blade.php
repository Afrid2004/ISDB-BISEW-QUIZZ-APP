<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Quizly - Learning Platform')
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-800 antialiased">

    <div class="min-h-screen">

        {{-- Mobile Overlay --}}
        <div id="sidebarOverlay" class="fixed inset-0 z-40 hidden bg-slate-900/50 lg:hidden">
        </div>

        {{-- Sidebar --}}
        @include('components.backend.sidebar')

        {{-- Main Area --}}
        <div class="lg:pl-64">

            {{-- Header --}}
            @include('components.backend.header')

            {{-- Page Content --}}
            <main class="p-4 sm:p-5 lg:p-6">
                @yield('content')
            </main>

        </div>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/sidebar.js') }}"></script>
    @stack('scripts')
</body>

</html>
