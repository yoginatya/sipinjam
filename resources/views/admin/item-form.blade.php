@extends('layouts.app')

@section('title', isset($item) ? __('messages.edit_item') : __('messages.add_item'))
@section('page-title', isset($item) ? __('messages.edit_item') : __('messages.add_item'))
@section('page-subtitle', __('messages.manage_inventory'))

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="rounded-2xl border border-[#e5eaf1] bg-white p-6 shadow-sm">
        <form method="POST"
              action="{{ isset($item) ? route('admin.items.update',$item) : route('admin.items.store') }}"
              enctype="multipart/form-data"
              class="space-y-5">
            @csrf
            @isset($item) @method('PUT') @endisset

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="mb-2 block text-xs font-bold">{{ __('messages.item_code') }}</label>
                    <input name="code" value="{{ old('code',$item->code ?? '') }}" required
                           class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-400 focus:outline-none">
                </div>

                <div>
                    <label class="mb-2 block text-xs font-bold">{{ __('messages.category') }}</label>
                    <select name="category_id" required class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-400 focus:outline-none">
                        <option value="">{{ __('messages.choose_category') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id',$item->category_id ?? '') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-2 block text-xs font-bold">{{ __('messages.item_name') }}</label>
                    <input name="name" value="{{ old('name',$item->name ?? '') }}" required
                           class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-400 focus:outline-none">
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-2 block text-xs font-bold">{{ __('messages.description') }}</label>
                    <textarea name="description" rows="4"
                              class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-400 focus:outline-none">{{ old('description',$item->description ?? '') }}</textarea>
                </div>

                <div>
                    <label class="mb-2 block text-xs font-bold">{{ __('messages.stock_quantity') }}</label>
                    <input type="number" min="0" name="stock" value="{{ old('stock',$item->stock ?? 0) }}" required
                           class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-400 focus:outline-none">
                    @isset($item)
                        <p class="mt-1 text-[11px] text-slate-400">{{ __('messages.stock_auto') }}</p>
                    @endisset
                </div>

                <div>
                    <label class="mb-2 block text-xs font-bold">{{ __('messages.condition') }}</label>
                    <select name="condition" required class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm focus:border-blue-400 focus:outline-none">
                        @foreach(['baik'=>__('messages.good'),'rusak_ringan'=>__('messages.minor_damage'),'rusak_berat'=>__('messages.major_damage')] as $value=>$label)
                            <option value="{{ $value }}" @selected(old('condition',$item->condition ?? 'baik') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-2 block text-xs font-bold">{{ __('messages.item_photo') }}</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-sm">
                    @isset($item)
                        @if($item->image)
                            <img src="{{ asset('storage/'.$item->image) }}" class="mt-3 h-24 w-24 rounded-xl object-cover">
                        @endif
                    @endisset
                </div>
            </div>

            <div class="flex gap-3 border-t border-slate-100 pt-5">
                <a href="{{ route('admin.items.index') }}" class="flex-1 rounded-xl border border-slate-200 py-2.5 text-center text-sm font-semibold">{{ __('messages.cancel') }}</a>
                <button class="primary-gradient flex-1 rounded-xl py-2.5 text-sm font-bold text-white">
                    {{ isset($item) ? __('messages.save_changes') : __('messages.add_item') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
