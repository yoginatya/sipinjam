@if(session('success'))
<div class="fixed right-5 top-5 z-[80] max-w-sm rounded-xl border border-emerald-200 bg-white px-4 py-3 text-sm font-semibold text-emerald-700 shadow-xl">
    ✓ {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="fixed right-5 top-5 z-[80] max-w-sm rounded-xl border border-red-200 bg-white px-4 py-3 text-sm font-semibold text-red-600 shadow-xl">
    {{ session('error') }}
</div>
@endif

@if($errors->any())
<div class="fixed right-5 top-5 z-[80] max-w-sm rounded-xl border border-red-200 bg-white px-4 py-3 text-sm text-red-600 shadow-xl">
    <div class="font-bold">{{ __('messages.check_data') }}</div>
    <ul class="mt-1 list-disc pl-5">
        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
    </ul>
</div>
@endif
