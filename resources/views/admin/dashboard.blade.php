@extends('layouts.app')

@section('title', __('messages.admin_dashboard'))

@section('page-title', __('messages.dashboard'))

@section('page-subtitle')
    {{ __('messages.admin_summary') }}
@endsection


@section('content')

<div class="space-y-5">


    
    <div
        class="hero-gradient
               relative overflow-hidden
               rounded-2xl p-7 text-white"
    >

        <div class="relative">

            <p
                class="mb-2 text-[11px]
                       font-bold uppercase
                       tracking-[.15em]
                       text-blue-200/60"
            >
                {{ __('messages.administrator') }}
            </p>

            <h2 class="text-2xl font-bold">
                {{ __('messages.welcome_comma') }}
                {{ auth()->user()->name }} 
            </h2>

            <p
                class="mt-2 max-w-lg
                       text-sm text-blue-100/70"
            >
                {{ __('messages.admin_intro') }}
            </p>

        </div>

    </div>


    
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

        @foreach([
            [
                'label' => __('messages.total_items'),
                'value' => $totalItems,
                'icon' => 'fa-solid fa-box',
                'color' => 'text-[#1b4e8a]'
            ],
            [
                'label' => __('messages.total_users'),
                'value' => $totalUsers,
                'icon' => 'fa-solid fa-users',
                'color' => 'text-[#2563c4]'
            ],
            [
                'label' => __('messages.loans'),
                'value' => $totalLoans,
                'icon' => 'fa-solid fa-clipboard-list',
                'color' => 'text-[#1b4e8a]'
            ],
            [
                'label' => __('messages.pending'),
                'value' => $pendingLoans,
                'icon' => 'fa-solid fa-clock',
                'color' => 'text-amber-600'
            ]
        ] as $stat)

            <div
                class="card-hover rounded-2xl
                       border border-[#e5eaf1]
                       bg-white p-5"
            >

                <div class="flex items-center justify-between">

                    <div>

                        <p
                            class="text-xs
                                   text-[#5e7899]"
                        >
                            {{ $stat['label'] }}
                        </p>

                        <p
                            class="mt-2 text-3xl
                                   font-bold
                                   {{ $stat['color'] }}"
                        >
                            {{ $stat['value'] }}
                        </p>

                    </div>

                    <div
                        class="flex h-11 w-11
                               items-center justify-center
                               rounded-xl bg-[#eaeff8]"
                    >
                        <i class="{{ $stat['icon'] }} text-lg {{ $stat['color'] }}"></i>
                    </div>

                </div>

            </div>

        @endforeach

    </div>


    
    <div
        class="overflow-hidden rounded-2xl
               border border-[#e5eaf1]
               bg-white"
    >

        <div
            class="border-b border-[#e5eaf1]
                   px-6 py-4"
        >

            <h3 class="text-sm font-bold">
                {{ __('messages.recent_loans_admin') }}
            </h3>

        </div>


        <div class="divide-y divide-[#e5eaf1]">

            @forelse($recentLoans as $loan)

                <div
                    class="flex items-center
                           justify-between gap-4
                           px-6 py-4"
                >

                    <div>

                        <p class="text-sm font-bold">
                            {{ $loan->user->name }}
                        </p>

                        <p
                            class="mt-1 text-xs
                                   text-[#5e7899]"
                        >
                            {{ $loan->details->first()?->item?->name }}
                        </p>

                    </div>

                    @include(
                        'components.status-badge',
                        ['status' => $loan->status]
                    )

                </div>

            @empty

                <div
                    class="p-10 text-center
                           text-sm text-[#5e7899]"
                >
                    {{ __('messages.no_loans') }}
                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection