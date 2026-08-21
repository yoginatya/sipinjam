@extends('layouts.app')

@section('title', __('messages.loan_detail'))

@section('page-title', __('messages.loan_detail'))

@section('content')

<div class="mx-auto max-w-3xl">

    <div
        class="rounded-2xl border
               border-[#e5eaf1]
               bg-white p-6 shadow-sm"
    >

        <div
            class="mb-6 flex flex-wrap
                   items-start justify-between gap-3
                   border-b border-[#e5eaf1]
                   pb-5"
        >

            <div>

                <p class="text-xs text-[#5e7899]">
                    {{ __('messages.loan_code') }}
                </p>

                <h2 class="mt-1 text-xl font-bold">
                    {{ $loan->loan_code }}
                </h2>

            </div>


            @include(
                'components.status-badge',
                ['status' => $loan->status]
            )

        </div>


        
        <div
            class="grid grid-cols-2 gap-4
                   border-b border-[#e5eaf1]
                   pb-6"
        >

            <div>

                <p class="text-xs text-[#5e7899]">
                    {{ __('messages.borrow_date') }}
                </p>

                <p class="mt-1 text-sm font-bold">
                    {{ $loan->borrow_date }}
                </p>

            </div>


            <div>

                <p class="text-xs text-[#5e7899]">
                    {{ __('messages.return_date') }}
                </p>

                <p class="mt-1 text-sm font-bold">
                    {{ $loan->return_date }}
                </p>

            </div>

        </div>


        
        <div class="py-6">

            <h3 class="mb-3 text-sm font-bold">
                {{ __('messages.item') }}
            </h3>

            <div class="space-y-2">

                @foreach($loan->details as $detail)

                    <div
                        class="flex items-center
                               justify-between
                               rounded-xl
                               bg-[#f4f6fb] p-3"
                    >

                        <div>

                            <p class="text-sm font-bold">
                                {{ $detail->item->name }}
                            </p>

                            <p class="text-xs text-[#5e7899]">
                                {{ $detail->item->category->name }}
                            </p>

                        </div>

                        <span class="text-sm font-bold">
                            × {{ $detail->quantity }}
                        </span>

                    </div>

                @endforeach

            </div>

        </div>


        
        <div
            class="border-t border-[#e5eaf1]
                   pt-5"
        >

            <p class="text-xs text-[#5e7899]">
                {{ __('messages.purpose') }}
            </p>

            <p class="mt-2 text-sm leading-6">
                {{ $loan->purpose }}
            </p>

        </div>

    </div>

</div>

@endsection