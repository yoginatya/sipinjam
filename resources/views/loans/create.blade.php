@extends('layouts.app')

@section('title', __('messages.borrow_item'))

@section('page-title', __('messages.loan_items'))

@section('page-subtitle')
    {{ __('messages.submit_loan_intro') }}
@endsection


@section('content')

<div class="mx-auto max-w-2xl">

    <div
        class="rounded-2xl border
               border-[#e5eaf1]
               bg-white p-6 shadow-sm"
    >

        <div class="mb-6">

            <h2 class="text-lg font-bold">
                Pinjam: {{ $item->name }}
            </h2>

            <p class="mt-1 text-xs text-[#5e7899]">
                {{ $item->category->name }}
                ·
                {{ __('messages.stock') }}: {{ $item->stock }}
            </p>

        </div>


        <form
            action="{{ route('loans.store') }}"
            method="POST"
            class="space-y-4"
        >

            @csrf

            <input
                type="hidden"
                name="item_id"
                value="{{ $item->id }}"
            >


            <div class="grid grid-cols-2 gap-3">

                <div>

                    <label class="mb-2 block text-xs font-bold">
                        {{ __('messages.borrow_date') }}
                    </label>

                    <input
                        type="date"
                        name="borrow_date"
                        min="{{ date('Y-m-d') }}"
                        value="{{ old('borrow_date') }}"
                        required
                        class="w-full rounded-xl
                               border border-[#dce3ed]
                               px-3.5 py-2.5 text-sm
                               outline-none
                               focus:border-blue-400"
                    >

                </div>


                <div>

                    <label class="mb-2 block text-xs font-bold">
                        {{ __('messages.return_date') }}
                    </label>

                    <input
                        type="date"
                        name="return_date"
                        min="{{ date('Y-m-d') }}"
                        value="{{ old('return_date') }}"
                        required
                        class="w-full rounded-xl
                               border border-[#dce3ed]
                               px-3.5 py-2.5 text-sm
                               outline-none
                               focus:border-blue-400"
                    >

                </div>

            </div>


            <div>

                <label class="mb-2 block text-xs font-bold">
                    {{ __('messages.quantity') }}
                </label>

                <input
                    type="number"
                    name="quantity"
                    min="1"
                    max="{{ $item->stock }}"
                    value="{{ old('quantity', 1) }}"
                    required
                    class="w-full rounded-xl
                           border border-[#dce3ed]
                           px-3.5 py-2.5 text-sm
                           outline-none
                           focus:border-blue-400"
                >

            </div>


            <div>

                <label class="mb-2 block text-xs font-bold">
                    {{ __('messages.purpose') }}
                </label>

                <textarea
                    name="purpose"
                    rows="3"
                    placeholder="{{ __('messages.purpose_placeholder') }}"
                    class="w-full resize-none rounded-xl
                           border border-[#dce3ed]
                           px-3.5 py-2.5 text-sm
                           outline-none
                           focus:border-blue-400"
                >{{ old('purpose') }}</textarea>

            </div>


            <div class="flex gap-3 pt-2">

                <a
                    href="{{ route('items.index') }}"
                    class="flex-1 rounded-xl
                           border border-[#dce3ed]
                           py-2.5 text-center
                           text-sm font-semibold
                           hover:bg-slate-50"
                >
                    {{ __('messages.cancel') }}
                </a>


                <button
                    type="submit"
                    class="primary-gradient flex-1
                           rounded-xl py-2.5
                           text-sm font-bold text-white
                           hover:brightness-110"
                >
                    {{ __('messages.submit_loan') }}
                </button>

            </div>

        </form>

    </div>

</div>

@endsection