<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $totalLoans = $user->loans()->count();
        $approvedLoans = $user->loans()->whereIn('status', ['approved', 'borrowed'])->count();
        $returnedLoans = $user->loans()->where('status', 'returned')->count();
        $recentLoans = $user->loans()->with(['details.item'])->latest()->take(5)->get();

        return view('profile.index', compact('user', 'totalLoans', 'approvedLoans', 'returnedLoans', 'recentLoans'));
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user->id)],
            'prodi' => ['nullable', 'string', 'max:100'],
            'angkatan' => ['nullable', 'digits:4'],
            'phone' => ['nullable', 'string', 'max:20'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'name.required' => __('messages.name_required'),
            'email.required' => __('messages.email_required'),
            'email.email' => __('messages.email_invalid'),
            'email.unique' => __('messages.email_used'),
            'angkatan.digits' => __('messages.year_invalid'),
            'profile_photo.image' => __('messages.photo_invalid'),
            'profile_photo.max' => __('messages.photo_max'),
        ]);

        if ($request->hasFile('profile_photo')) {
            $this->removeStoredPhoto($user->profile_photo);
            $data['profile_photo'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $user->update($data);
        return back()->with('success', __('messages.profile_saved'));
    }

    public function updatePassword(Request $request)
    {
        $this->changePassword($request);
        return back()->with('success', __('messages.password_saved'));
    }

    public function admin()
    {
        return view('admin.profile');
    }

    public function adminUpdate(Request $request)
    {
        return $this->update($request);
    }

    public function adminUpdatePassword(Request $request)
    {
        $this->changePassword($request);
        return back()->with('success', __('messages.password_saved'));
    }

    public function deletePhoto(Request $request)
    {
        $user = $request->user();
        $this->removeStoredPhoto($user->profile_photo);
        $user->update(['profile_photo' => null]);

        return back()->with('success', __('messages.photo_deleted'));
    }

    private function changePassword(Request $request): void
    {
        $data = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => __('messages.current_password_required'),
            'current_password.current_password' => __('messages.current_password_invalid'),
            'password.required' => __('messages.new_password_required'),
            'password.min' => __('messages.password_min'),
            'password.confirmed' => __('messages.password_confirmed'),
        ]);

        $request->user()->update(['password' => $data['password']]);
    }

    private function removeStoredPhoto(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
