<header class="fixed left-0 right-0 top-0 z-30 flex h-[73px] items-center justify-between border-b border-[#e5eaf1] bg-white/95 px-4 shadow-sm backdrop-blur-xl lg:left-64 lg:px-6">
    <div class="flex min-w-0 items-center gap-3">
        <button type="button" id="mobile-menu-button" aria-controls="app-sidebar" aria-expanded="false" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-[#e5eaf1] bg-white text-[#0e1c2f] shadow-sm transition hover:bg-[#f4f6fb] lg:hidden">
            <i id="menu-open-icon" class="fa-solid fa-bars text-base"></i>
        </button>
        <div class="min-w-0">
            <h1 class="truncate text-base font-bold text-[#0e1c2f]">@yield('page-title', __('messages.dashboard'))</h1>
            <p class="mt-0.5 hidden truncate text-xs text-[#5e7899] sm:block">@yield('page-subtitle', __('messages.campus_borrowing_portal'))</p>
        </div>
    </div>
    <div class="flex items-center gap-2 sm:gap-3">
        <a href="{{ route('language.switch', app()->getLocale() === 'id' ? 'en' : 'id') }}" class="flex items-center gap-1 rounded-lg border border-slate-200 px-2 py-1.5 text-[10px] font-bold text-slate-600 transition hover:bg-slate-50 sm:gap-1.5 sm:px-2.5" title="{{ __('messages.language') }}">
            <i class="fa-solid fa-globe"></i>
            <span>{{ app()->getLocale() === 'id' ? 'EN' : 'ID' }}</span>
        </a>
    </div>
</header>