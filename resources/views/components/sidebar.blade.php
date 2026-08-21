
<div id="sidebar-overlay" class="fixed inset-0 z-40 hidden bg-slate-950/50 backdrop-blur-[2px] lg:hidden"></div>

<aside
    id="app-sidebar"
    class="sidebar-bg fixed left-0 top-0 z-50 flex h-screen w-64 -translate-x-full flex-col shadow-2xl transition-transform duration-300 ease-out lg:translate-x-0 lg:shadow-none"
    aria-label="Navigasi utama"
>
    <div class="flex items-center justify-between border-b border-white/[.06] px-5 py-5">
        <div class="flex items-center gap-3">
            <div class="flex h-14 w-14 items-center justify-center overflow-hidden">
                <img src="{{ asset('images/logo.png') }}" alt="SiPinjam" class="h-full w-full object-cover">
            </div>
            <div>
                <div class="text-sm font-bold tracking-wide text-white">{{ __('messages.SiPinjam') }}</div>
                <div class="mt-0.5 text-[10px] uppercase tracking-widest text-blue-200/50">
                    {{ auth()->user()->role === 'admin' ? __('messages.admin_portal') : __('messages.student_portal') }}
                </div>
            </div>
        </div>

        
        <button
            type="button"
            id="mobile-menu-close"
            class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-white/70 transition hover:bg-white/10 hover:text-white lg:hidden"
            aria-label="Tutup menu"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" data-sidebar-link class="relative flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-500/[.16] text-[#e0eeff]' : 'text-white/45 hover:bg-white/[.06] hover:text-white' }}">
                <i class="fa-solid fa-house w-5 text-center"></i><span>{{ __('messages.dashboard') }}</span>
            </a>
            <a href="{{ route('admin.items.index') }}" data-sidebar-link class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.items.*') ? 'bg-blue-500/[.16] text-[#e0eeff]' : 'text-white/45 hover:bg-white/[.06] hover:text-white' }}">
                <i class="fa-solid fa-box w-5 text-center"></i><span>{{ __('messages.items') }}</span>
            </a>
            <a href="{{ route('admin.loans.index') }}" data-sidebar-link class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.loans.*') ? 'bg-blue-500/[.16] text-[#e0eeff]' : 'text-white/45 hover:bg-white/[.06] hover:text-white' }}">
                <i class="fa-solid fa-clipboard-list w-5 text-center"></i><span class="flex-1">{{ __('messages.loans') }}</span>
                @php $pending = \App\Models\Loan::where('status', 'pending')->count(); @endphp
                @if($pending > 0)<span class="rounded-full bg-blue-500 px-1.5 py-0.5 text-[10px] font-bold text-white">{{ $pending }}</span>@endif
            </a>
            <a href="{{ route('admin.users.index') }}" data-sidebar-link class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.users.*') ? 'bg-blue-500/[.16] text-[#e0eeff]' : 'text-white/45 hover:bg-white/[.06] hover:text-white' }}">
                <i class="fa-solid fa-users w-5 text-center"></i><span>{{ __('messages.users') }}</span>
            </a>
            <a href="{{ route('admin.profile') }}" data-sidebar-link class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.profile') ? 'bg-blue-500/[.16] text-[#e0eeff]' : 'text-white/45 hover:bg-white/[.06] hover:text-white' }}">
                <i class="fa-solid fa-user w-5 text-center"></i><span>{{ __('messages.profile') }}</span>
            </a>
        @else
            <a href="{{ route('dashboard') }}" data-sidebar-link class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-blue-500/[.16] text-[#e0eeff]' : 'text-white/45 hover:bg-white/[.06] hover:text-white' }}">
                <i class="fa-solid fa-house w-5 text-center"></i><span>{{ __('messages.dashboard') }}</span>
            </a>
            <a href="{{ route('items.index') }}" data-sidebar-link class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium {{ request()->routeIs('items.*') ? 'bg-blue-500/[.16] text-[#e0eeff]' : 'text-white/45 hover:bg-white/[.06] hover:text-white' }}">
                <i class="fa-solid fa-box w-5 text-center"></i><span>{{ __('messages.catalog') }}</span>
            </a>
            <a href="{{ route('loans.index') }}" data-sidebar-link class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium {{ request()->routeIs('loans.*') ? 'bg-blue-500/[.16] text-[#e0eeff]' : 'text-white/45 hover:bg-white/[.06] hover:text-white' }}">
                <i class="fa-solid fa-clock-rotate-left w-5 text-center"></i><span class="flex-1">{{ __('messages.history') }}</span>
                @php $pendingMine = auth()->user()->loans()->where('status', 'pending')->count(); @endphp
                @if($pendingMine > 0)<span class="rounded-full bg-blue-500 px-1.5 py-0.5 text-[10px] font-bold text-white">{{ $pendingMine }}</span>@endif
            </a>
            <a href="{{ route('profile.index') }}" data-sidebar-link class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium {{ request()->routeIs('profile.*') ? 'bg-blue-500/[.16] text-[#e0eeff]' : 'text-white/45 hover:bg-white/[.06] hover:text-white' }}">
                <i class="fa-solid fa-user w-5 text-center"></i><span>{{ __('messages.profile') }}</span>
            </a>
        @endif
    </nav>

    <div class="mx-3 mb-4 rounded-2xl border border-white/[.07] bg-white/[.05] p-3">
        <a href="{{ auth()->user()->role === 'admin' ? route('admin.profile') : route('profile.index') }}" data-sidebar-link class="mb-3 flex items-center gap-3 rounded-xl p-1 transition hover:bg-white/[.06]">
            <div class="flex h-9 w-9 items-center justify-center overflow-hidden rounded-full bg-gradient-to-br from-blue-600 to-blue-400 text-sm font-bold text-white">
                @if(auth()->user()->profile_photo)
                    <img src="{{ asset('storage/'.auth()->user()->profile_photo) }}" alt="{{ __('messages.photo') }}" class="h-full w-full object-cover">
                @else
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                @endif
            </div>
            <div class="min-w-0 flex-1">
                <div class="truncate text-xs font-bold text-white">{{ auth()->user()->name }}</div>
                <div class="truncate text-[10px] text-blue-300/60">{{ auth()->user()->nim ?? auth()->user()->email }}</div>
            </div>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full rounded-lg py-1.5 text-xs font-semibold text-white/35 transition hover:bg-red-500/[.08] hover:text-red-300"><i class="fa-solid fa-right-from-bracket mr-2"></i>{{ __('messages.logout') }}</button>
        </form>
    </div>
</aside>
