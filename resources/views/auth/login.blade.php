<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - {{ __('messages.SiPinjam') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-[#f4f6fb]">

    <div class="fixed right-4 top-4 z-50 flex items-center gap-1 rounded-xl border border-slate-200 bg-white/95 p-1 shadow-sm backdrop-blur">
        <a href="{{ route('language.switch','id') }}"
           class="rounded-lg px-2.5 py-1.5 text-[10px] font-bold {{ app()->getLocale()==='id' ? 'bg-blue-600 text-white' : 'text-slate-500 hover:bg-slate-100' }}">
            ID
        </a>

        <a href="{{ route('language.switch','en') }}"
           class="rounded-lg px-2.5 py-1.5 text-[10px] font-bold {{ app()->getLocale()==='en' ? 'bg-blue-600 text-white' : 'text-slate-500 hover:bg-slate-100' }}">
            EN
        </a>
    </div>

    <div class="min-h-screen flex">

        <div class="hidden lg:flex lg:w-1/2
                    bg-gradient-to-br from-[#0a1628] via-[#102b4c] to-[#2563c7]
                    relative overflow-hidden">

            <div class="absolute w-96 h-96 rounded-full
                        bg-blue-500/10 -top-32 -right-32">
            </div>

            <div class="absolute w-72 h-72 rounded-full
                        bg-blue-400/10 bottom-[-100px] left-[-80px]">
            </div>

            <div class="relative z-10 flex flex-col
                        justify-center px-16 text-white">

                <div class="flex items-center gap-3 mb-8">

                    <div class="flex h-14 w-14 items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/logo.png') }}" alt="SiPinjam" class="h-full w-full object-cover">
                    </div>

                    <div>

                        <h1 class="font-bold text-xl">
                            {{ __('messages.SiPinjam') }}
                        </h1>

                        <p class="text-blue-300 text-xs tracking-wide">
                            {{ __('messages.portal_label') }}
                        </p>

                    </div>

                </div>

                <h2 class="text-4xl font-bold leading-tight mb-5">

                    {{ __('messages.welcome') }}

                    <span class="text-blue-400">
                        {{ __('messages.back') }}
                    </span>

                </h2>

                <p class="text-blue-100 leading-relaxed max-w-md">

                    {{ __('messages.login_intro') }}

                </p>

                <div class="flex flex-wrap gap-2 mt-7">

                    <span class="px-3 py-1 rounded-full
                                 bg-blue-500/10
                                 border border-blue-400/20
                                 text-blue-200 text-xs">

                        {{ __('messages.realtime_status') }}

                    </span>

                    <span class="px-3 py-1 rounded-full
                                 bg-blue-500/10
                                 border border-blue-400/20
                                 text-blue-200 text-xs">

                        {{ __('messages.digital_approval') }}

                    </span>

                    <span class="px-3 py-1 rounded-full
                                 bg-blue-500/10
                                 border border-blue-400/20
                                 text-blue-200 text-xs">

                        {{ __('messages.complete_history') }}

                    </span>

                </div>

            </div>

        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center
                    px-6 py-10">

            <div class="w-full max-w-md">

                <div class="lg:hidden text-center mb-8">

                    <div class="inline-flex w-28 h-28 items-center justify-center">

                        <img
                            src="{{ asset('images/logo.png') }}"
                            alt="SiPinjam"
                            class="h-full w-full object-cover">

                    </div>

                    <h1 class="font-bold text-xl text-[#0e1c2f]">
                        {{ __('messages.SiPinjam') }}
                    </h1>

                </div>

                <div class="bg-white rounded-2xl
                            border border-gray-100
                            shadow-sm p-8">

                    <div class="mb-7">

                        <h2 class="text-2xl font-bold text-[#0e1c2f]">

                            {{ __('messages.welcome') }}
                            <i class="fa-solid fa-hand"></i>

                        </h2>

                        <p class="text-gray-500 text-sm mt-2">

                            {{ __('messages.login_continue') }}

                        </p>

                    </div>

                    @if ($errors->any())

                        <div class="mb-5 rounded-xl
                                    bg-red-50
                                    border border-red-200
                                    p-4">

                            <ul class="text-sm text-red-600 space-y-1">

                                @foreach ($errors->all() as $error)

                                    <li>
                                        • {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif

                    <form
                        method="POST"
                        action="{{ route('login.store') }}"
                        class="space-y-5">

                        @csrf

                        <div>

                            <label
                                class="block text-sm font-semibold
                                       text-gray-700 mb-2">

                                {{ __('messages.email') }}

                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                placeholder="{{ __('messages.email_placeholder') }}"
                                class="w-full px-4 py-3 rounded-xl
                                       border border-gray-200
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-blue-500/20
                                       focus:border-blue-500
                                       transition">

                        </div>

                        <div>

                            <label
                                class="block text-sm font-semibold
                                       text-gray-700 mb-2">

                                {{ __('messages.password_label') }}

                            </label>

                            <input
                                type="password"
                                name="password"
                                required
                                placeholder="{{ __('messages.enter_password') }}"
                                class="w-full px-4 py-3 rounded-xl
                                       border border-gray-200
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-blue-500/20
                                       focus:border-blue-500
                                       transition">

                        </div>

                        <div class="flex items-center">

                            <label class="flex items-center gap-2">

                                <input
                                    type="checkbox"
                                    name="remember"
                                    value="1"
                                    class="w-4 h-4
                                           rounded
                                           border-gray-300
                                           text-blue-600
                                           focus:ring-blue-500">

                                <span class="text-sm text-gray-500">

                                    {{ __('messages.remember_me') }}

                                </span>

                            </label>

                        </div>

                        <button
                            type="submit"
                            class="w-full py-3.5 rounded-xl
                                   bg-blue-600 hover:bg-blue-700
                                   text-white font-semibold
                                   transition
                                   shadow-lg
                                   shadow-blue-600/20">

                            {{ __('messages.login_button') }}

                        </button>

                    </form>

                    <div class="text-center mt-6">

                        <p class="text-sm text-gray-500">

                            {{ __('messages.no_account') }}

                            <a
                                href="{{ route('register') }}"
                                class="font-semibold text-blue-600
                                       hover:text-blue-700">

                                {{ __('messages.register_student') }}

                            </a>

                        </p>

                    </div>

                </div>

                <p class="text-center text-xs text-gray-400 mt-6">

                    © {{ date('Y') }} {{ __('messages.SiPinjam') }} —
                    {{ __('messages.campus_borrowing_portal') }}

                </p>

            </div>

        </div>

    </div>

</body>

</html>