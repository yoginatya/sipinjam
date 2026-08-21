@extends('layouts.app')

@section('title', __('messages.profile'))
@section('page-title', __('messages.profile'))
@section('page-subtitle', __('messages.manage_admin_account'))

@section('content')

<div class="mx-auto max-w-4xl space-y-4 sm:space-y-5">
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

                    @if(auth()->user()->profile_photo)

                        <img
                            id="admin-profile-photo-preview"
                            src="{{ \Illuminate\Support\Facades\Storage::url(auth()->user()->profile_photo) }}"
                            alt="{{ __('messages.photo') }}"
                            class="h-full w-full rounded-full object-cover"
                        >

                        <span
                            id="admin-profile-photo-initial"
                            class="hidden"
                        >
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>

                    @else

                        <span id="admin-profile-photo-initial">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>

                        <img
                            id="admin-profile-photo-preview"
                            src=""
                            alt="{{ __('messages.photo') }}"
                            class="hidden h-full w-full rounded-full object-cover"
                        >

                    @endif

                </div>


                {{-- ADMIN INFORMATION --}}
                <div class="min-w-0 flex-1 sm:pb-0.5">

                    <div class="flex flex-wrap items-center gap-2">

                        <h2 class="text-lg font-bold text-[#0e1c2f] sm:text-xl">
                            {{ auth()->user()->name }}
                        </h2>

                        <span class="rounded-full bg-blue-50 px-2 py-0.5 text-[9px] font-bold text-blue-700">
                            {{ __('messages.administrator_short') }}
                        </span>

                    </div>

                    <p class="mt-0.5 truncate text-[10px] text-[#5e7899]">
                        {{ auth()->user()->email }}
                    </p>

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
                    {{ __('messages.profile') }}
                </h3>

            </div>


            <form
                method="POST"
                action="{{ route('admin.profile.update') }}"
                enctype="multipart/form-data"
                class="space-y-3.5"
            >

                @csrf
                @method('PUT')


                {{-- PHOTO --}}
                <div>

                    <label class="mb-1.5 block text-[9px] font-bold uppercase text-[#0e1c2f]">
                        {{ __('messages.photo') }}
                    </label>


                    <div class="flex flex-wrap items-center gap-2 rounded-xl border border-dashed border-[#cbd5e1] bg-[#f8fafc] p-3">

                        {{-- CHOOSE PHOTO --}}
                        <label
                            for="admin_profile_photo"
                            class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-white px-3 py-2 text-[10px] font-bold text-[#1b4e8a] shadow-sm ring-1 ring-slate-200 transition hover:bg-blue-50"
                        >

                            <i class="fa-solid fa-camera"></i>

                            {{ __('messages.choose_photo') }}

                        </label>


                        {{-- DELETE PHOTO --}}
                        @if(auth()->user()->profile_photo)

                            <button
                                type="submit"
                                form="delete-admin-photo"
                                class="inline-flex items-center gap-2 rounded-lg bg-red-50 px-3 py-2 text-[10px] font-bold text-red-600 ring-1 ring-red-100 transition hover:bg-red-100"
                                onclick="return confirm('{{ __('messages.delete_photo') }}?')"
                            >

                                <i class="fa-solid fa-trash"></i>

                                {{ __('messages.delete_photo') }}

                            </button>

                        @endif


                        {{-- FILE NAME --}}
                        <span
                            id="admin-profile-photo-name"
                            class="min-w-0 truncate text-[10px] text-[#5e7899]"
                        >
                            {{ __('messages.photo_help') }}
                        </span>

                    </div>


                    <input
                        id="admin_profile_photo"
                        name="profile_photo"
                        type="file"
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
                        value="{{ old('name', auth()->user()->name) }}"
                        class="w-full rounded-xl border border-[#dce3ed] bg-[#eaf0f9] px-3 py-2.5 text-xs outline-none transition focus:border-[#2563c4] focus:ring-2 focus:ring-blue-100"
                    >

                    @error('name')

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
                        value="{{ old('email', auth()->user()->email) }}"
                        class="w-full rounded-xl border border-[#dce3ed] bg-[#eaf0f9] px-3 py-2.5 text-xs outline-none transition focus:border-[#2563c4] focus:ring-2 focus:ring-blue-100"
                    >

                    @error('email')

                        <p class="mt-1 text-[10px] text-red-500">
                            {{ $message }}
                        </p>

                    @enderror

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
                id="delete-admin-photo"
                method="POST"
                action="{{ route('admin.profile.photo.delete') }}"
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
                action="{{ route('admin.profile.password.update') }}"
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

    const photoInput = document.getElementById('admin_profile_photo');
    const photoPreview = document.getElementById('admin-profile-photo-preview');
    const photoInitial = document.getElementById('admin-profile-photo-initial');
    const photoName = document.getElementById('admin-profile-photo-name');

    let objectUrl = null;


    if (photoInput) {

        photoInput.addEventListener('change', function () {

            const file = this.files?.[0];

            if (!file) {
                return;
            }


            // VALIDATE FORMAT
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


            // VALIDATE SIZE - MAX 2 MB
            const maxSize = 2 * 1024 * 1024;

            if (file.size > maxSize) {

                alert('Ukuran foto maksimal 2 MB.');

                this.value = '';

                return;
            }


            // SHOW FILE NAME
            if (photoName) {
                photoName.textContent = file.name;
            }


            // REMOVE OLD OBJECT URL
            if (objectUrl) {
                URL.revokeObjectURL(objectUrl);
            }


            // CREATE PREVIEW
            objectUrl = URL.createObjectURL(file);

            if (photoPreview) {

                photoPreview.src = objectUrl;

                photoPreview.classList.remove('hidden');

            }


            // HIDE INITIAL
            if (photoInitial) {
                photoInitial.classList.add('hidden');
            }

        });

    }


    // CLEAN OBJECT URL
    window.addEventListener('beforeunload', function () {

        if (objectUrl) {
            URL.revokeObjectURL(objectUrl);
        }

    });

});
</script>
@endpush