@extends('layouts.app')

@section('title', __('messages.catalog'))

@section('page-title', __('messages.catalog'))

@section('page-subtitle')
    {{ __('messages.catalog_intro') }}
@endsection


@section('content')

<div class="space-y-4">

    
    <form
        method="GET"
        action="{{ route('items.index') }}"
    >

        <div class="relative">

            <span
                class="absolute left-3 top-1/2
                       -translate-y-1/2
                       text-[#5e7899]"
            >
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="{{ __('messages.search_items') }}"
                class="w-full rounded-xl
                       border border-[#dce3ed]
                       bg-white px-3.5 py-2.5
                       pl-10 text-sm
                       outline-none
                       transition
                       focus:border-blue-400
                       focus:ring-2
                       focus:ring-blue-100"
            >

        </div>

    </form>


    
    <div class="flex gap-2 overflow-x-auto pb-1">

        <a
            href="{{ route('items.index') }}"
            class="whitespace-nowrap rounded-full
                   px-4 py-1.5 text-xs font-bold
                   {{ !request('category')
                        ? 'primary-gradient text-white'
                        : 'bg-[#eaeff8] text-[#5e7899]' }}"
        >
            {{ __('messages.all') }}
        </a>


        @foreach($categories as $category)

            <a
                href="{{ route(
                    'items.index',
                    ['category' => $category->id]
                ) }}"
                class="whitespace-nowrap rounded-full
                       px-4 py-1.5 text-xs font-bold
                       {{ request('category') == $category->id
                            ? 'primary-gradient text-white'
                            : 'bg-[#eaeff8] text-[#5e7899]' }}"
            >
                {{ $category->name }}
            </a>

        @endforeach

    </div>


    
    <div
        class="grid grid-cols-1 gap-4
               sm:grid-cols-2 lg:grid-cols-3"
    >

        @forelse($items as $item)

            <div
                class="card-hover overflow-hidden
                       rounded-2xl border
                       border-[#e5eaf1]
                       bg-white"
            >

                
                <div
                    class="group relative h-48
                           overflow-hidden bg-[#eaeff8]"
                >

                    @if($item->image)

                        <img
                            src="{{ asset(
                                'storage/' . $item->image
                            ) }}"
                            alt="{{ $item->name }}"
                            class="h-full w-full
                                   object-cover
                                   transition duration-700
                                   group-hover:scale-105"
                        >

                    @else

                        <div
                            class="flex h-full
                                   items-center justify-center
                                   text-6xl"
                        >
                            <i class="fa-solid fa-box"></i>
                        </div>

                    @endif


                    <div
                        class="absolute inset-0"
                        style="
                            background:
                            linear-gradient(
                                to top,
                                rgba(10,21,37,.75),
                                transparent 55%
                            );
                        "
                    ></div>


                    <span
                        class="absolute left-3 top-3
                               rounded-lg
                               border border-white/10
                               bg-[#0e1c2f]/65
                               px-2.5 py-1
                               text-[10px] font-bold
                               uppercase tracking-wide
                               text-white"
                    >
                        {{ $item->category->name }}
                    </span>


                    @if($item->stock <= 0)

                        <span
                            class="absolute right-3 top-3
                                   rounded-lg
                                   bg-red-500/30
                                   px-2 py-1
                                   text-[10px]
                                   font-bold text-red-100"
                        >
                            {{ __('messages.out') }}
                        </span>

                    @endif

                </div>


                
                <div class="p-4">

                    <h3
                        class="mb-1 truncate
                               text-sm font-bold"
                    >
                        {{ $item->name }}
                    </h3>


                    <p
                        class="mb-3 line-clamp-2
                               text-xs text-[#5e7899]"
                    >
                        {{ $item->description }}
                    </p>


                    
                    <div class="mb-3">

                        <div
                            class="mb-1 flex
                                   items-center justify-between
                                   text-xs"
                        >

                            <span class="text-[#5e7899]">
                                {{ __('messages.availability') }}
                            </span>

                            <span
                                class="font-bold
                                {{ $item->stock <= 0
                                    ? 'text-red-500'
                                    : ($item->stock <= 2
                                        ? 'text-amber-600'
                                        : 'text-green-600') }}"
                            >
                                {{ $item->available_stock }} unit
                            </span>

                        </div>


                        <div
                            class="h-1.5 w-full
                                   rounded-full
                                   bg-[#eaeff8]"
                        >

                            <div
                                class="h-full rounded-full
                                {{ $item->stock <= 0
                                    ? 'bg-red-500'
                                    : ($item->stock <= 2
                                        ? 'bg-amber-500'
                                        : 'bg-blue-500') }}"
                                style="
                                    width:
                                    {{ min(100, ($item->available_stock / max(1, $item->stock)) * 100) }}%;
                                "
                            ></div>

                        </div>

                    </div>


                    @if($item->stock > 0)

                        <a
                            href="{{ route(
                                'loans.create',
                                ['item' => $item->id]
                            ) }}"
                            class="primary-gradient
                                   block w-full rounded-xl
                                   py-2.5 text-center
                                   text-sm font-bold text-white
                                   transition hover:brightness-110"
                        >
                            {{ __('messages.borrow_now') }}
                        </a>

                    @else

                        <button
                            disabled
                            class="w-full rounded-xl
                                   bg-slate-300 py-2.5
                                   text-sm font-bold
                                   text-slate-500"
                        >
                            {{ __('messages.out_of_stock') }}
                        </button>

                    @endif

                </div>

            </div>

        @empty

            <div
                class="col-span-full py-20
                       text-center text-[#5e7899]"
            >

                <div class="mb-3 text-5xl">
                    <i class="fa-solid fa-box"></i>
                </div>

                <p class="text-sm">
                    {{ __('messages.no_items') }}
                </p>

            </div>

        @endforelse

    </div>


    
    <div>
        {{ $items->withQueryString()->links() }}
    </div>

</div>

@endsection