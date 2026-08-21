@php
$config = [
    'pending' => ['label' => __('messages.pending'), 'class' => 'bg-amber-50 text-amber-700 border-amber-200'],
    'approved' => ['label' => __('messages.approved'), 'class' => 'bg-blue-50 text-blue-700 border-blue-200'],
    'borrowed' => ['label' => __('messages.borrowed'), 'class' => 'bg-indigo-50 text-indigo-700 border-indigo-200'],
    'returned' => ['label' => __('messages.returned_loans'), 'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
    'rejected' => ['label' => __('messages.rejected'), 'class' => 'bg-red-50 text-red-600 border-red-200'],
    'cancelled' => ['label' => __('messages.cancelled'), 'class' => 'bg-slate-100 text-slate-600 border-slate-200'],
];
$current = $config[$status] ?? [
    'label' => ucfirst($status),
    'class' => 'bg-slate-100 text-slate-600 border-slate-200'
];
@endphp

<span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-[11px] font-semibold {{ $current['class'] }}">
    {{ $current['label'] }}
</span>
