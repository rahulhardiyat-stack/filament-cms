<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'SatgasPPKS')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap");

        body {
            font-family: "Inter", sans-serif;
        }

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .asymmetric-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 1.5rem;
        }

        .span-5 {
            grid-column: span 5;
        }

        .span-7 {
            grid-column: span 7;
        }

        .span-4 {
            grid-column: span 4;
        }

        .span-8 {
            grid-column: span 8;
        }

        @media (max-width: 768px) {
            .asymmetric-grid>* {
                grid-column: span 12 !important;
            }
        }

        .line-clamp-2,
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            -webkit-line-clamp: 2;
        }

        .line-clamp-3 {
            -webkit-line-clamp: 3;
        }
    </style>
    @yield('styles')
</head>

<body class="bg-white text-gray-900">
    @include('components.nav')

    <main>
        @yield('content')
    </main>

    @unless(request()->routeIs('lapor.*'))
        @include('components.newsletter')
    @endunless
    @include('components.footer')

    @stack('scripts')
</body>

</html>
