@extends('layouts.app')

@section('title', __('messages.dashboard').' - SiPinjam')

@section('page-title', __('messages.dashboard'))

@section('page-subtitle')
    {{ auth()->user()->nim }}
    ·
    {{ auth()->user()->prodi ?? __('messages.student') }}
@endsection


@section('content')

<div class="space-y-5">

    
    <div
        class="hero-gradient relative
               overflow-hidden rounded-2xl
               p-7 text-white shadow-xl"
    >

        <div
            class="absolute -right-10 -top-10
                   h-56 w-56 rounded-full
                   bg-white opacity-[.06]"
        ></div>

        <div
            class="absolute bottom-0 right-20
                   h-32 w-32 rounded-full
                   bg-white opacity-[.04]"
        ></div>


        <div class="relative">

            <div
                class="mb-2 text-[11px]
                       font-bold uppercase
                       tracking-[.15em]
                       text-blue-200/60"
            >
                {{ __('messages.welcome_back') }}
            </div>


            <h2 class="mb-1 text-2xl font-bold">
                {{ explode(' ', auth()->user()->name)[0] }}
            </h2>


            <p
                class="mb-5 max-w-sm
                    text-sm leading-relaxed
                    text-blue-100/70"
            >
                {{ __('messages.dashboard_intro_short') }}
            </p>


            <a
                href="{{ route('items.index') }}"
                class="inline-flex items-center gap-2
                       rounded-xl border
                       border-white/20
                       bg-white/10 px-5 py-2.5
                       text-sm font-bold
                       backdrop-blur-md
                       transition hover:bg-white/20"
            >
                {{ __('messages.borrow_item') }}
            </a>

        </div>

    </div>


    
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

        <div
            class="card-hover relative
                   overflow-hidden rounded-2xl
                   border border-[#e5eaf1]
                   bg-white p-5 text-center"
        >

            <div
                class="absolute left-0 right-0 top-0
                       h-0.5 bg-[#1b4e8a]"
            ></div>

            <div class="text-[2rem] font-bold text-[#1b4e8a]">
                {{ $totalLoans }}
            </div>

            <div class="mt-1.5 text-[11px] text-[#5e7899]">
                {{ __('messages.total') }}
            </div>

        </div>


        <div
            class="card-hover relative
                   overflow-hidden rounded-2xl
                   border border-[#e5eaf1]
                   bg-white p-5 text-center"
        >

            <div
                class="absolute left-0 right-0 top-0
                       h-0.5 bg-[#2563c4]"
            ></div>

            <div class="text-[2rem] font-bold text-[#2563c4]">
                {{ $borrowedLoans }}
            </div>

            <div class="mt-1.5 text-[11px] text-[#5e7899]">
                {{ __('messages.borrowed') }}
            </div>

        </div>


        <div
            class="card-hover relative
                   overflow-hidden rounded-2xl
                   border border-[#e5eaf1]
                   bg-white p-5 text-center"
        >

            <div
                class="absolute left-0 right-0 top-0
                       h-0.5 bg-amber-500"
            ></div>

            <div class="text-[2rem] font-bold text-amber-600">
                {{ $pendingLoans }}
            </div>

            <div class="mt-1.5 text-[11px] text-[#5e7899]">
                {{ __('messages.pending') }}
            </div>

        </div>

    </div>


    
    <div
        class="overflow-hidden rounded-2xl
               border border-[#e5eaf1]
               bg-white"
    >

        <div
            class="flex items-center justify-between
                   border-b border-[#e5eaf1]
                   px-6 py-4"
        >

            <h3 class="text-sm font-bold">
                {{ __('messages.recent') }}
            </h3>

            <a
                href="{{ route('loans.index') }}"
                class="text-xs font-semibold
                       text-[#2563c4] hover:underline"
            >
                {{ __('messages.view_all') }}
            </a>

        </div>


        <div class="divide-y divide-[#e5eaf1]">

            @forelse($recentLoans as $loan)

                <div
                    class="flex items-center gap-4
                           px-6 py-3.5
                           transition hover:bg-blue-50/30"
                >

                    <div
                        class="flex h-9 w-9
                               flex-shrink-0
                               items-center justify-center
                               rounded-xl bg-[#eaeff8]"
                    >
                        <i class="fa-solid fa-box"></i>
                    </div>


                    <div class="min-w-0 flex-1">

                        <div
                            class="truncate text-sm
                                   font-bold"
                        >
                            {{ $loan->details->first()?->item?->name
                                ?? __('messages.item') }}
                        </div>

                        <div
                            class="text-xs text-[#5e7899]"
                        >
                            {{ $loan->borrow_date }}
                            —
                            {{ $loan->return_date }}
                        </div>

                    </div>


                    @include(
                        'components.status-badge',
                        ['status' => $loan->status]
                    )

                </div>

            @empty

                <div
                    class="px-6 py-10
                           text-center text-sm
                           text-[#5e7899]"
                >
                    {{ __('messages.no_recent_history') }}
                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection