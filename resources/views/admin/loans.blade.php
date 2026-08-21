@extends('layouts.app')

@section('title', __('messages.loans'))

@section('page-title', __('messages.loans'))

@section('page-subtitle')
    {{ __('messages.manage_student_loans') }}
@endsection


@section('content')

<div
    class="overflow-hidden rounded-2xl
           border border-[#e5eaf1]
           bg-white"
>

    <div class="overflow-x-auto">

        <table class="w-full text-left">

            <thead
                class="border-b border-[#e5eaf1]
                       bg-[#f8fafc]"
            >

                <tr>

                    <th class="px-5 py-4 text-xs">
                        {{ __('messages.student') }}
                    </th>

                    <th class="px-5 py-4 text-xs">
                        {{ __('messages.item') }}
                    </th>

                    <th class="px-5 py-4 text-xs">
                        {{ __('messages.date') }}
                    </th>

                    <th class="px-5 py-4 text-xs">
                        {{ __('messages.status') }}
                    </th>

                    <th class="px-5 py-4 text-xs">
                        {{ __('messages.actions') }}
                    </th>

                </tr>

            </thead>


            <tbody
                class="divide-y divide-[#e5eaf1]"
            >

                @forelse($loans as $loan)

                    <tr class="hover:bg-blue-50/30">

                        <td class="px-5 py-4">

                            <p class="text-sm font-bold">
                                {{ $loan->user->name }}
                            </p>

                            <p
                                class="text-[11px]
                                       text-[#5e7899]"
                            >
                                {{ $loan->user->nim }}
                            </p>

                        </td>


                        <td class="px-5 py-4">

                            @foreach($loan->details as $detail)

                                <p class="text-xs">
                                    {{ $detail->item->name }}
                                    × {{ $detail->quantity }}
                                </p>

                            @endforeach

                        </td>


                        <td
                            class="px-5 py-4
                                   text-xs"
                        >
                            {{ $loan->borrow_date }}
                            <br>
                            {{ $loan->return_date }}
                        </td>


                        <td class="px-5 py-4">

                            @include(
                                'components.status-badge',
                                ['status' => $loan->status]
                            )

                        </td>


                        <td class="px-5 py-4">

                            @if($loan->status === 'pending')

                                <div class="flex gap-2">

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'admin.loans.approve',
                                            $loan
                                        ) }}"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            class="rounded-lg
                                                   bg-emerald-50
                                                   px-3 py-1.5
                                                   text-xs font-bold
                                                   text-emerald-700"
                                        >
                                            {{ __('messages.approve') }}
                                        </button>

                                    </form>


                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'admin.loans.reject',
                                            $loan
                                        ) }}"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            class="rounded-lg
                                                   bg-red-50
                                                   px-3 py-1.5
                                                   text-xs font-bold
                                                   text-red-600"
                                        >
                                            {{ __('messages.reject') }}
                                        </button>

                                    </form>

                                </div>

                            @elseif($loan->status === 'approved')

                                <form method="POST" action="{{ route('admin.loans.borrow',$loan) }}">
                                    @csrf @method('PATCH')
                                    <button class="rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-700">{{ __('messages.hand_over') }}</button>
                                </form>

                            @elseif($loan->status === 'borrowed')

                                <form method="POST" action="{{ route('admin.loans.return',$loan) }}">
                                    @csrf @method('PATCH')
                                    <button class="rounded-lg bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700">{{ __('messages.return') }}</button>
                                </form>

                            @else

                                <span class="text-xs text-[#5e7899]">{{ __('messages.no_action') }}</span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            class="px-5 py-12
                                   text-center
                                   text-sm
                                   text-[#5e7899]"
                        >
                            {{ __('messages.no_loan_data') }}
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="border-t border-slate-100 p-4">{{ $loans->links() }}</div>
</div>

@endsection