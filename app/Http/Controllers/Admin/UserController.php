<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::latest();

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nim', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(15);

        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        if ($user->is(auth()->user())) {
            return back()->with('error', __('messages.cannot_change_own_role'));
        }

        $data = $request->validate([
            'role' => ['required', Rule::in(['mahasiswa', 'admin'])],
        ]);

        $user->update(['role' => $data['role']]);

        return back()->with('success', __('messages.role_updated'));
    }

    public function destroy(User $user)
    {
        if ($user->is(auth()->user())) {
            return back()->with('error', __('messages.cannot_delete_self'));
        }

        if ($user->loans()->exists()) {
            return back()->with('error', __('messages.user_has_loans'));
        }

        $user->delete();

        return back()->with('success', __('messages.user_deleted'));
    }
}
