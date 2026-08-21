<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => [
                    'required',
                    'email',
                ],

                'password' => [
                    'required',
                    'string',
                ],
            ],
            [
                'email.required' => __('messages.email_required'),
                'email.email' => __('messages.email_invalid'),

                'password.required' => __('messages.password_required'),
            ]
        );

        if (!Auth::attempt(
            [
                'email' => $credentials['email'],
                'password' => $credentials['password'],
            ],
            $request->boolean('remember')
        )) {

            return back()
                ->withErrors([
                    'email' => __('messages.login_password_error'),
                ])
                ->withInput(
                    $request->only('email')
                );
        }

        $request->session()->regenerate();

        if (Auth::user()->role === 'admin') {

            return redirect()
                ->route('admin.dashboard');

        }

        return redirect()
            ->route('dashboard');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:100',
                ],

                'nim' => [
                    'required',
                    'string',
                    'max:30',
                    'unique:users,nim',
                ],

                'prodi' => [
                    'required',
                    'string',
                    'max:100',
                ],

                'email' => [
                    'required',
                    'email',
                    'max:150',
                    'unique:users,email',
                ],

                'password' => [
                    'required',
                    'confirmed',
                    Password::min(8),
                ],
            ],
            [
                'name.required' =>
                    __('messages.name_required'),

                'name.max' => __('messages.name_max'),

                'nim.required' =>
                    __('messages.nim_required'),

                'nim.max' => __('messages.nim_max'),

                'nim.unique' => __('messages.nim_used'),

                'prodi.required' =>
                    __('messages.study_program_required'),

                'prodi.max' => __('messages.study_program_max'),

                'email.required' => __('messages.email_required'),

                'email.email' => __('messages.email_invalid'),

                'email.max' => __('messages.email_max'),

                'email.unique' => __('messages.email_used'),

                'password.required' => __('messages.password_required'),

                'password.confirmed' => __('messages.password_confirmed'),
            ]
        );

        $user = User::create([
            'name' => $data['name'],
            'nim' => $data['nim'],
            'prodi' => $data['prodi'],
            'email' => $data['email'],

            'role' => 'mahasiswa',

            'password' => $data['password'],
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                __('messages.student_created')
            );
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with(
                'success',
                __('messages.logged_out')
            );
    }
}