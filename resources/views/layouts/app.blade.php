<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('messages.SiPinjam'))</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background:#f4f6fb; color:#0e1c2f; }
        .sidebar-bg { background:linear-gradient(180deg,#0a1628 0%,#0e1c2f 100%); }
        .primary-gradient { background:linear-gradient(135deg,#1b4e8a,#2563c4); }
        .hero-gradient { background:linear-gradient(135deg,#091525 0%,#0e1c2f 40%,#1b4e8a 75%,#2563c4 100%); }
        .card-hover { transition:transform .2s ease,box-shadow .2s ease; }
        .card-hover:hover { transform:translateY(-2px);box-shadow:0 12px 32px rgba(27,78,138,.12); }
        .page-animation { animation:pageIn .25s ease-out; }
        @keyframes pageIn { from{opacity:0;transform:translateY(7px)} to{opacity:1;transform:translateY(0)} }
        ::-webkit-scrollbar { width:6px;height:6px; }
        ::-webkit-scrollbar-thumb { background:#cbd5e1;border-radius:999px; }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen">
@auth
    @include('components.sidebar')
    <main class="flex min-h-screen flex-col pt-[73px] lg:ml-64">
        @include('components.navbar')
        <div class="flex-1 p-4 sm:p-6 page-animation">
            @include('components.flash')
            @yield('content')
        </div>
        @include('components.footer')
    </main>
@else
    @include('components.flash')
    @yield('content')
@endauth
@stack('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('app-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const openButton = document.getElementById('mobile-menu-button');
        const closeButton = document.getElementById('mobile-menu-close');
        const openIcon = document.getElementById('menu-open-icon');
        const closeIcon = document.getElementById('menu-close-icon');

        if (!sidebar || !overlay || !openButton) return;

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            overlay.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            openButton.setAttribute('aria-expanded', 'true');
            openIcon?.classList.add('hidden');
            closeIcon?.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            openButton.setAttribute('aria-expanded', 'false');
            openIcon?.classList.remove('hidden');
            closeIcon?.classList.add('hidden');
        }

        openButton.addEventListener('click', function () {
            const expanded = openButton.getAttribute('aria-expanded') === 'true';
            expanded ? closeSidebar() : openSidebar();
        });
        closeButton?.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);
        document.querySelectorAll('[data-sidebar-link]').forEach(link => link.addEventListener('click', closeSidebar));
        document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSidebar(); });
        window.addEventListener('resize', () => { if (window.innerWidth >= 1024) closeSidebar(); });
    });
</script>
</body>
</html>
