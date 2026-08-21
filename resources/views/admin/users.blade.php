@extends('layouts.app')

@section('title', __('messages.users'))
@section('page-title', __('messages.users'))
@section('page-subtitle', __('messages.manage_users'))

@section('content')

<div class="space-y-5">

    <form method="GET" class="flex gap-2">

        <div class="relative flex-1">

            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>

            <input
                name="search"
                value="{{ request('search') }}"
                placeholder="{{ __('messages.search_users') }}"
                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 pl-10 text-sm outline-none focus:border-blue-400"
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

                <thead class="border-b border-slate-200 bg-slate-50">

                    <tr>

                        <th class="px-5 py-4 text-xs">
                            {{ __('messages.users') }}
                        </th>

                        <th class="px-5 py-4 text-xs">
                            {{ __('messages.nim') }}
                        </th>

                        <th class="px-5 py-4 text-xs">
                            {{ __('messages.role') }}
                        </th>

                        <th class="px-5 py-4 text-xs">
                            {{ __('messages.actions') }}
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                @forelse($users as $user)

                    <tr class="hover:bg-blue-50/30">

                        <td class="px-5 py-4">

                            <p class="text-sm font-bold">
                                {{ $user->name }}
                            </p>

                            <p class="text-[11px] text-slate-400">
                                {{ $user->email }}
                            </p>

                        </td>


                        <td class="px-5 py-4 text-xs">
                            {{ $user->nim ?? '-' }}
                        </td>


                        <td class="px-5 py-4">

                            <form
                                method="POST"
                                action="{{ route('admin.users.role', $user) }}"
                            >

                                @csrf
                                @method('PATCH')

                                <select
                                    name="role"
                                    onchange="this.form.submit()"
                                    class="rounded-lg border border-slate-200 px-2.5 py-1.5 text-xs font-semibold"
                                >

                                    <option
                                        value="mahasiswa"
                                        @selected($user->role === 'mahasiswa')
                                    >
                                        {{ __('messages.student') }}
                                    </option>

                                    <option
                                        value="admin"
                                        @selected($user->role === 'admin')
                                    >
                                        {{ __('messages.administrator_short') }}
                                    </option>

                                </select>

                            </form>

                        </td>


                        <td class="px-5 py-4">

                            @if(!$user->is(auth()->user()))

                                <form
                                    method="POST"
                                    action="{{ route('admin.users.destroy', $user) }}"
                                    onsubmit="return confirm('{{ __('messages.delete_user_confirm') }}')"
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

                            @else

                                <span class="text-xs text-slate-400">
                                    {{ __('messages.your_account') }}
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="4"
                            class="px-5 py-12 text-center text-sm text-slate-400"
                        >
                            {{ __('messages.no_users') }}
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>


        <div class="border-t border-slate-100 p-4">
            {{ $users->withQueryString()->links() }}
        </div>

    </div>

</div>

@endsection