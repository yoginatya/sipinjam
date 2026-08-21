@extends('layouts.app')

@section('title', __('messages.profile'))
@section('page-title', __('messages.profile'))
@section('page-subtitle', __('messages.manage_account'))

@section('content')
<div class="space-y-4 sm:space-y-5">

    {{-- PROFILE HEADER --}}
    <section class="overflow-hidden rounded-2xl border border-[#e5eaf1] bg-white shadow-sm">

        <div class="hero-gradient relative h-24 sm:h-28">
            <div class="absolute -left-8 -top-12 h-36 w-36 rounded-full bg-white/[.07]"></div>
            <div class="absolute right-[-30px] top-[-45px] h-40 w-40 rounded-full bg-white/[.05]"></div>
            <div class="absolute bottom-[-45px] left-1/2 h-28 w-28 rounded-full bg-white/[.04]"></div>
        </div>

        <div class="relative px-4 pb-4 sm:px-6 sm:pb-5">

            <div class="-mt-8 flex flex-col gap-3 sm:-mt-9 sm:flex-row sm:items-end sm:gap-4">

                {{-- PROFILE PHOTO --}}
                <div class="relative flex h-16 w-16 flex-shrink-0 items-center justify-center overflow-hidden rounded-full border-2 border-white bg-gradient-to-br from-[#3b82f6] to-[#1d4ed8] text-2xl font-bold text-white shadow-md sm:h-20 sm:w-20 sm:text-3xl">

                    @if($user->profile_photo)

                        <img
                            id="profile-photo-preview"
                            src="{{ \Illuminate\Support\Facades\Storage::url($user->profile_photo) }}"
                            alt="{{ __('messages.photo') }}"
                            class="h-full w-full rounded-full object-cover"
                        >

                        <span
                            id="profile-photo-initial"
                            class="hidden"
                        >
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>

                    @else

                        <span id="profile-photo-initial">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>

                        <img
                            id="profile-photo-preview"
                            src=""
                            alt="{{ __('messages.photo') }}"
                            class="hidden h-full w-full rounded-full object-cover"
                        >

                    @endif

                </div>

                {{-- USER INFO --}}
                <div class="min-w-0 flex-1 sm:pb-0.5">

                    <div class="flex flex-wrap items-center gap-2">

                        <h2 class="text-lg font-bold text-[#0e1c2f] sm:text-xl">
                            {{ $user->name }}
                        </h2>

                        <span class="rounded-full bg-blue-50 px-2 py-0.5 text-[9px] font-bold text-blue-700">
                            {{ __('messages.student') }}
                        </span>

                    </div>

                    <p class="mt-0.5 text-[10px] text-[#5e7899]">
                        {{ $user->nim ?? '-' }}
                    </p>

                </div>

            </div>

            {{-- ACCOUNT INFORMATION --}}
            <div class="mt-4 grid grid-cols-1 gap-2 sm:grid-cols-3">

                <div class="rounded-xl bg-[#eaf0f9] px-3 py-2.5">

                    <p class="text-[9px] font-semibold uppercase tracking-wide text-[#5e7899]">
                        {{ __('messages.email') }}
                    </p>

                    <p class="mt-0.5 truncate text-[11px] font-medium text-[#0e1c2f]">
                        {{ $user->email }}
                    </p>

                </div>

                <div class="rounded-xl bg-[#eaf0f9] px-3 py-2.5">

                    <p class="text-[9px] font-semibold uppercase tracking-wide text-[#5e7899]">
                        {{ __('messages.study_program_short') }}
                    </p>

                    <p class="mt-0.5 truncate text-[11px] font-medium text-[#0e1c2f]">
                        {{ $user->prodi ?? '-' }}
                    </p>

                </div>

                <div class="rounded-xl bg-[#eaf0f9] px-3 py-2.5">

                    <p class="text-[9px] font-semibold uppercase tracking-wide text-[#5e7899]">
                        {{ __('messages.year') }}
                    </p>

                    <p class="mt-0.5 text-[11px] font-medium text-[#0e1c2f]">
                        {{ $user->angkatan ?? '-' }}
                    </p>

                </div>

            </div>

            {{-- LOAN STATISTICS --}}
            <div class="mt-2 grid grid-cols-3 gap-2">

                <div class="rounded-xl border border-[#e5eaf1] bg-white px-2 py-3 text-center">

                    <div class="text-xl font-bold text-[#1b4e8a]">
                        {{ $totalLoans }}
                    </div>

                    <div class="mt-0.5 text-[8px] text-[#5e7899] sm:text-[9px]">
                        {{ __('messages.total_loans') }}
                    </div>

                </div>

                <div class="rounded-xl border border-[#e5eaf1] bg-white px-2 py-3 text-center">

                    <div class="text-xl font-bold text-[#2563c4]">
                        {{ $approvedLoans }}
                    </div>

                    <div class="mt-0.5 text-[8px] text-[#5e7899] sm:text-[9px]">
                        {{ __('messages.approved_loans') }}
                    </div>

                </div>

                <div class="rounded-xl border border-[#e5eaf1] bg-white px-2 py-3 text-center">

                    <div class="text-xl font-bold text-emerald-500">
                        {{ $returnedLoans }}
                    </div>

                    <div class="mt-0.5 text-[8px] text-[#5e7899] sm:text-[9px]">
                        {{ __('messages.returned_loans') }}
                    </div>

                </div>

            </div>

        </div>
    </section>


    {{-- PROFILE + PASSWORD --}}
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

        {{-- PROFILE INFORMATION --}}
        <section class="rounded-2xl border border-[#e5eaf1] bg-white p-4 shadow-sm sm:p-5">

            <div class="mb-4 flex items-center gap-2">

                <i class="fa-solid fa-user-pen text-sm text-[#2563c4]"></i>

                <h3 class="text-xs font-bold text-[#0e1c2f]">
                    {{ __('messages.profile_info') }}
                </h3>

            </div>


            <form
                method="POST"
                action="{{ route('profile.update') }}"
                enctype="multipart/form-data"
                class="space-y-3.5"
            >

                @csrf
                @method('PUT')


                {{-- PROFILE PHOTO --}}
                <div>

                    <label class="mb-1.5 block text-[9px] font-bold uppercase text-[#0e1c2f]">
                        {{ __('messages.photo') }}
                    </label>

                    <div class="flex flex-wrap items-center gap-2 rounded-xl border border-dashed border-[#cbd5e1] bg-[#f8fafc] p-3">

                        <label
                            for="profile_photo"
                            class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-white px-3 py-2 text-[10px] font-bold text-[#1b4e8a] shadow-sm ring-1 ring-slate-200 transition hover:bg-blue-50"
                        >
                            <i class="fa-solid fa-camera"></i>

                            {{ __('messages.choose_photo') }}
                        </label>


                        @if($user->profile_photo)

                            <button
                                type="submit"
                                form="delete-profile-photo"
                                class="inline-flex items-center gap-2 rounded-lg bg-red-50 px-3 py-2 text-[10px] font-bold text-red-600 ring-1 ring-red-100 transition hover:bg-red-100"
                                onclick="return confirm('{{ __('messages.delete_photo') }}?')"
                            >

                                <i class="fa-solid fa-trash"></i>

                                {{ __('messages.delete_photo') }}

                            </button>

                        @endif


                        <span
                            id="profile-photo-name"
                            class="min-w-0 truncate text-[10px] text-[#5e7899]"
                        >
                            {{ __('messages.photo_help') }}
                        </span>

                    </div>


                    <input
                        id="profile_photo"
                        type="file"
                        name="profile_photo"
                        accept="image/jpeg,image/png,image/webp"
                        class="hidden"
                    >

                    @error('profile_photo')
                        <p class="mt-1 text-[10px] text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- FULL NAME --}}
                <div>

                    <label class="mb-1.5 block text-[9px] font-bold uppercase text-[#0e1c2f]">
                        {{ __('messages.full_name') }}
                    </label>

                    <input
                        type="text"
                        name="name"
                        required
                        value="{{ old('name', $user->name) }}"
                        class="w-full rounded-xl border border-[#dce3ed] bg-[#eaf0f9] px-3 py-2.5 text-xs outline-none transition focus:border-[#2563c4] focus:ring-2 focus:ring-blue-100"
                    >

                    @error('name')
                        <p class="mt-1 text-[10px] text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- PRODI + ANGKATAN --}}
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

                    <div>

                        <label class="mb-1.5 block text-[9px] font-bold uppercase text-[#0e1c2f]">
                            {{ __('messages.study_program') }}
                        </label>

                        <input
                            type="text"
                            name="prodi"
                            value="{{ old('prodi', $user->prodi) }}"
                            class="w-full rounded-xl border border-[#dce3ed] bg-[#eaf0f9] px-3 py-2.5 text-xs outline-none transition focus:border-[#2563c4] focus:ring-2 focus:ring-blue-100"
                        >

                        @error('prodi')
                            <p class="mt-1 text-[10px] text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    <div>

                        <label class="mb-1.5 block text-[9px] font-bold uppercase text-[#0e1c2f]">
                            {{ __('messages.year') }}
                        </label>

                        <input
                            type="text"
                            name="angkatan"
                            inputmode="numeric"
                            maxlength="4"
                            pattern="[0-9]{4}"
                            value="{{ old('angkatan', $user->angkatan) }}"
                            class="w-full rounded-xl border border-[#dce3ed] bg-[#eaf0f9] px-3 py-2.5 text-xs outline-none transition focus:border-[#2563c4] focus:ring-2 focus:ring-blue-100"
                        >

                        @error('angkatan')
                            <p class="mt-1 text-[10px] text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>


                {{-- PHONE --}}
                <div>

                    <label class="mb-1.5 block text-[9px] font-bold uppercase text-[#0e1c2f]">
                        {{ __('messages.phone') }}
                    </label>

                    <input
                        type="tel"
                        name="phone"
                        value="{{ old('phone', $user->phone) }}"
                        placeholder="08xxxxxxxxxx"
                        class="w-full rounded-xl border border-[#dce3ed] bg-[#eaf0f9] px-3 py-2.5 text-xs outline-none transition focus:border-[#2563c4] focus:ring-2 focus:ring-blue-100"
                    >

                    @error('phone')
                        <p class="mt-1 text-[10px] text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- EMAIL --}}
                <div>

                    <label class="mb-1.5 block text-[9px] font-bold uppercase text-[#0e1c2f]">
                        {{ __('messages.email') }}
                    </label>

                    <input
                        type="email"
                        name="email"
                        required
                        value="{{ old('email', $user->email) }}"
                        class="w-full rounded-xl border border-[#dce3ed] bg-[#eaf0f9] px-3 py-2.5 text-xs outline-none transition focus:border-[#2563c4] focus:ring-2 focus:ring-blue-100"
                    >

                    @error('email')
                        <p class="mt-1 text-[10px] text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- NIM --}}
                <div>

                    <label class="mb-1.5 block text-[9px] font-bold uppercase text-[#0e1c2f]">
                        {{ __('messages.nim') }}
                    </label>

                    <input
                        type="text"
                        value="{{ $user->nim ?? '-' }}"
                        disabled
                        class="w-full cursor-not-allowed rounded-xl border border-[#dce3ed] bg-slate-100 px-3 py-2.5 text-xs text-slate-500"
                    >

                </div>


                {{-- SAVE --}}
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-[#1b4e8a] to-[#2563c4] px-4 py-2.5 text-xs font-bold text-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
                >

                    <i class="fa-solid fa-floppy-disk"></i>

                    {{ __('messages.save_changes') }}

                </button>

            </form>


            {{-- DELETE PHOTO FORM --}}
            <form
                id="delete-profile-photo"
                method="POST"
                action="{{ route('profile.photo.delete') }}"
                class="hidden"
            >
                @csrf
                @method('DELETE')
            </form>

        </section>


        {{-- CHANGE PASSWORD --}}
        <section class="rounded-2xl border border-[#e5eaf1] bg-white p-4 shadow-sm sm:p-5">

            <div class="mb-4 flex items-center gap-2">

                <i class="fa-solid fa-lock text-sm text-[#2563c4]"></i>

                <h3 class="text-xs font-bold text-[#0e1c2f]">
                    {{ __('messages.change_password') }}
                </h3>

            </div>


            <form
                method="POST"
                action="{{ route('profile.password.update') }}"
                class="space-y-3.5"
            >

                @csrf
                @method('PUT')


                {{-- CURRENT PASSWORD --}}
                <div>

                    <label class="mb-1.5 block text-[9px] font-bold uppercase text-[#0e1c2f]">
                        {{ __('messages.current_password') }}
                    </label>

                    <input
                        type="password"
                        name="current_password"
                        required
                        autocomplete="current-password"
                        placeholder="{{ __('messages.current_password') }}"
                        class="w-full rounded-xl border border-[#dce3ed] bg-[#eaf0f9] px-3 py-2.5 text-xs outline-none transition focus:border-[#2563c4] focus:ring-2 focus:ring-blue-100"
                    >

                    @error('current_password')
                        <p class="mt-1 text-[10px] text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- NEW PASSWORD --}}
                <div>

                    <label class="mb-1.5 block text-[9px] font-bold uppercase text-[#0e1c2f]">
                        {{ __('messages.new_password') }}
                    </label>

                    <input
                        type="password"
                        name="password"
                        required
                        minlength="8"
                        autocomplete="new-password"
                        placeholder="{{ __('messages.password_min_hint') }}"
                        class="w-full rounded-xl border border-[#dce3ed] bg-[#eaf0f9] px-3 py-2.5 text-xs outline-none transition focus:border-[#2563c4] focus:ring-2 focus:ring-blue-100"
                    >

                    @error('password')
                        <p class="mt-1 text-[10px] text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- CONFIRM PASSWORD --}}
                <div>

                    <label class="mb-1.5 block text-[9px] font-bold uppercase text-[#0e1c2f]">
                        {{ __('messages.confirm_password') }}
                    </label>

                    <input
                        type="password"
                        name="password_confirmation"
                        required
                        minlength="8"
                        autocomplete="new-password"
                        placeholder="{{ __('messages.confirm_password_hint') }}"
                        class="w-full rounded-xl border border-[#dce3ed] bg-[#eaf0f9] px-3 py-2.5 text-xs outline-none transition focus:border-[#2563c4] focus:ring-2 focus:ring-blue-100"
                    >

                </div>


                {{-- UPDATE PASSWORD --}}
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-[#1b4e8a] to-[#2563c4] px-4 py-2.5 text-xs font-bold text-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
                >

                    <i class="fa-solid fa-key"></i>

                    {{ __('messages.update_password') }}

                </button>

            </form>

        </section>

    </div>

</div>
@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const profilePhotoInput = document.getElementById('profile_photo');
    const profilePhotoPreview = document.getElementById('profile-photo-preview');
    const profilePhotoInitial = document.getElementById('profile-photo-initial');
    const profilePhotoName = document.getElementById('profile-photo-name');

    let currentObjectUrl = null;

    if (profilePhotoInput) {

        profilePhotoInput.addEventListener('change', function () {

            const file = this.files && this.files[0];

            if (!file) {
                return;
            }

            const allowedTypes = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];

            if (!allowedTypes.includes(file.type)) {

                alert('Format foto harus JPG, PNG, atau WEBP.');

                this.value = '';

                return;
            }

            const maxSize = 2 * 1024 * 1024;

            if (file.size > maxSize) {

                alert('Ukuran foto maksimal 2 MB.');

                this.value = '';

                return;
            }


            profilePhotoName.textContent = file.name;


            if (currentObjectUrl) {
                URL.revokeObjectURL(currentObjectUrl);
            }


            currentObjectUrl = URL.createObjectURL(file);

            profilePhotoPreview.src = currentObjectUrl;

            profilePhotoPreview.classList.remove('hidden');

            profilePhotoInitial?.classList.add('hidden');

        });

    }


    window.addEventListener('beforeunload', function () {

        if (currentObjectUrl) {
            URL.revokeObjectURL(currentObjectUrl);
        }

    });

});
</script>
@endpush