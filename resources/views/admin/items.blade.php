```php
@extends('layouts.app')

@section('title', __('messages.items'))
@section('page-title', __('messages.items'))
@section('page-subtitle', __('messages.manage_items'))

@section('content')

<div class="space-y-5">

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-lg font-bold">
                {{ __('messages.item_list') }}
            </h2>

            <p class="text-xs text-[#5e7899]">
                {{ __('messages.total') }} {{ $items->total() }} {{ __('messages.items') }}
            </p>
        </div>

        <a
            href="{{ route('admin.items.create') }}"
            class="primary-gradient rounded-xl px-4 py-2.5 text-center text-sm font-bold text-white"
        >
            + {{ __('messages.add_item') }}
        </a>

    </div>


    <form method="GET" class="flex gap-2">

        <div class="relative flex-1">

            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>

            <input
                name="search"
                value="{{ request('search') }}"
                placeholder="{{ __('messages.search_item_code') }}"
                class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm outline-none focus:border-blue-400"
            >

        </div>

        <button
            type="submit"
            class="rounded-xl bg-[#1b4e8a] px-5 py-2.5 text-sm font-bold text-white"
        >
            <i class="fa-solid fa-magnifying-glass mr-2"></i>
            {{ __('messages.search') }}
        </button>

    </form>


    <div class="overflow-hidden rounded-2xl border border-[#e5eaf1] bg-white">

        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead class="border-b border-[#e5eaf1] bg-[#f8fafc]">

                    <tr>

                        <th class="px-5 py-4 text-xs">
                            {{ __('messages.item') }}
                        </th>

                        <th class="px-5 py-4 text-xs">
                            {{ __('messages.category') }}
                        </th>

                        <th class="px-5 py-4 text-xs">
                            {{ __('messages.stock') }}
                        </th>

                        <th class="px-5 py-4 text-xs">
                            {{ __('messages.available') }}
                        </th>

                        <th class="px-5 py-4 text-xs">
                            {{ __('messages.condition') }}
                        </th>

                        <th class="px-5 py-4 text-xs">
                            {{ __('messages.actions') }}
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-[#e5eaf1]">

                @forelse($items as $item)

                    <tr class="hover:bg-blue-50/30">

                        <td class="px-5 py-4">

                            <div class="flex items-center gap-3">

                                <div class="h-10 w-10 overflow-hidden rounded-xl bg-[#eaeff8]">

                                    @if($item->image)

                                        <img
                                            src="{{ asset('storage/'.$item->image) }}"
                                            class="h-full w-full object-cover"
                                            alt="{{ $item->name }}"
                                        >

                                    @else

                                        <div class="flex h-full items-center justify-center text-slate-400">
                                            <i class="fa-solid fa-box"></i>
                                        </div>

                                    @endif

                                </div>

                                <div>

                                    <p class="text-sm font-bold">
                                        {{ $item->name }}
                                    </p>

                                    <p class="text-[11px] text-[#5e7899]">
                                        {{ $item->code }}
                                    </p>

                                </div>

                            </div>

                        </td>


                        <td class="px-5 py-4 text-xs">
                            {{ $item->category->name }}
                        </td>


                        <td class="px-5 py-4 text-sm font-bold">
                            {{ $item->stock }}
                        </td>


                        <td class="px-5 py-4 text-sm font-bold text-blue-600">
                            {{ $item->available_stock }}
                        </td>


                        <td class="px-5 py-4 text-xs capitalize">
                            {{ __('messages.condition_'.$item->condition) }}
                        </td>


                        <td class="px-5 py-4">

                            <div class="flex gap-2">

                                <a
                                    href="{{ route('admin.items.edit', $item) }}"
                                    class="rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-bold text-blue-700"
                                >
                                    {{ __('messages.edit') }}
                                </a>


                                <form
                                    method="POST"
                                    action="{{ route('admin.items.destroy', $item) }}"
                                    onsubmit="return confirm('{{ __('messages.delete') }} barang ini?')"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-bold text-red-600"
                                    >
                                        {{ __('messages.delete') }}
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="px-5 py-12 text-center text-sm text-[#5e7899]"
                        >
                            {{ __('messages.no_items') }}
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>


        <div class="border-t border-slate-100 p-4">
            {{ $items->withQueryString()->links() }}
        </div>

    </div>

</div>

@endsection
```
