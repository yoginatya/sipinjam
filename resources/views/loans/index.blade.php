@extends('layouts.app')

@section('title', __('messages.loan_history'))

@section('page-title', __('messages.my_history'))

@section('page-subtitle')
    {{ __('messages.my_loans_intro') }}
@endsection


@section('content')

<div class="space-y-3">

    @forelse($loans as $loan)

        <div
            class="card-hover flex gap-4
                   rounded-2xl border
                   border-[#e5eaf1]
                   bg-white p-4"
        >

            <div
                class="flex h-10 w-10
                       flex-shrink-0
                       items-center justify-center
                       rounded-xl bg-[#eaeff8]"
            >
                <i class="fa-solid fa-box"></i>
            </div>


            <div class="min-w-0 flex-1">

                <div
                    class="flex flex-wrap
                           items-start justify-between gap-2"
                >

                    <div>

                        <div class="text-sm font-bold">
                            {{ $loan->details->first()?->item?->name
                                ?? __('messages.item') }}
                        </div>

                        <div
                            class="mt-0.5 text-xs
                                   text-[#5e7899]"
                        >
                            {{ __('messages.quantity_colon') }}
                            {{ $loan->details->sum('quantity') }}

                            ·

                            {{ $loan->borrow_date }}
                            s/d
                            {{ $loan->return_date }}
                        </div>

                        @if($loan->purpose)

                            <div
                                class="mt-1 text-xs italic
                                       text-[#5e7899]"
                            >
                                "{{ $loan->purpose }}"
                            </div>

                        @endif

                    </div>


                    @include(
                        'components.status-badge',
                        ['status' => $loan->status]
                    )

                </div>

            </div>

        </div>

    @empty

        <div
            class="py-24 text-center
                   text-[#5e7899]"
        >

            <div class="mb-3 text-5xl">
                📋
            </div>

            <p class="text-sm">
                {{ __('messages.no_history_plain') }}
            </p>

            <a
                href="{{ route('items.index') }}"
                class="mt-4 inline-block
                       rounded-xl
                       bg-[#1b4e8a] px-5 py-2.5
                       text-sm font-bold text-white"
            >
                {{ __('messages.view_catalog') }}
            </a>

        </div>

    @endforelse


    <div>
        {{ $loans->links() }}
    </div>

</div>

@endsection