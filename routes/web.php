<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ItemController as AdminItemController;
use App\Http\Controllers\Admin\LoanController as AdminLoanController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::middleware('guest')->group(function () {

    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/language/{locale}', function (Request $request, string $locale) {
    abort_unless(in_array($locale, ['id', 'en'], true), 404);
    $request->session()->put('locale', $locale);
    return redirect()->back();
})->name('language.switch');

Route::middleware(['auth', 'role:mahasiswa'])
    ->group(function () {

        Route::get('/dashboard', [
            DashboardController::class,
            'index'
        ])->name('dashboard');

        Route::get('/katalog', [
            ItemController::class,
            'index'
        ])->name('items.index');

        Route::get('/katalog/{item}', [
            ItemController::class,
            'show'
        ])->name('items.show');

        Route::get('/peminjaman', [
            LoanController::class,
            'index'
        ])->name('loans.index');

        Route::get('/peminjaman/create/{item}', [
            LoanController::class,
            'create'
        ])->name('loans.create');

        Route::post('/peminjaman', [
            LoanController::class,
            'store'
        ])->name('loans.store');

        Route::get('/peminjaman/{loan}', [
            LoanController::class,
            'show'
        ])->name('loans.show');

        Route::get('/profil', [
            ProfileController::class,
            'index'
        ])->name('profile.index');

        Route::put('/profil', [
            ProfileController::class,
            'update'
        ])->name('profile.update');

        Route::put('/profil/password', [
            ProfileController::class,
            'updatePassword'
        ])->name('profile.password.update');

        Route::delete('/profil/foto', [
            ProfileController::class,
            'deletePhoto'
        ])->name('profile.photo.delete');
    });

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/dashboard', [
            AdminDashboardController::class,
            'index'
        ])->name('dashboard');

        Route::get('/barang', [
            AdminItemController::class,
            'index'
        ])->name('items.index');

        Route::get('/barang/create', [
            AdminItemController::class,
            'create'
        ])->name('items.create');

        Route::post('/barang', [
            AdminItemController::class,
            'store'
        ])->name('items.store');

        Route::get('/barang/{item}/edit', [
            AdminItemController::class,
            'edit'
        ])->name('items.edit');

        Route::put('/barang/{item}', [
            AdminItemController::class,
            'update'
        ])->name('items.update');

        Route::delete('/barang/{item}', [
            AdminItemController::class,
            'destroy'
        ])->name('items.destroy');

        Route::get('/peminjaman', [
            AdminLoanController::class,
            'index'
        ])->name('loans.index');

        Route::get('/peminjaman/{loan}', [
            AdminLoanController::class,
            'show'
        ])->name('loans.show');

        Route::patch('/peminjaman/{loan}/approve', [
            AdminLoanController::class,
            'approve'
        ])->name('loans.approve');

        Route::patch('/peminjaman/{loan}/reject', [
            AdminLoanController::class,
            'reject'
        ])->name('loans.reject');

        Route::patch('/peminjaman/{loan}/borrow', [
            AdminLoanController::class,
            'borrow'
        ])->name('loans.borrow');

        Route::patch('/peminjaman/{loan}/return', [
            AdminLoanController::class,
            'returnLoan'
        ])->name('loans.return');

        Route::get('/pengguna', [
            AdminUserController::class,
            'index'
        ])->name('users.index');

        Route::patch('/pengguna/{user}/role', [
            AdminUserController::class,
            'updateRole'
        ])->name('users.role');

        Route::delete('/pengguna/{user}', [
            AdminUserController::class,
            'destroy'
        ])->name('users.destroy');

        Route::get('/profil', [
            ProfileController::class,
            'admin'
        ])->name('profile');

        Route::put('/profil', [
            ProfileController::class,
            'adminUpdate'
        ])->name('profile.update');

        Route::put('/profil/password', [
            ProfileController::class,
            'adminUpdatePassword'
        ])->name('profile.password.update');

        Route::delete('/profil/foto', [
            ProfileController::class,
            'deletePhoto'
        ])->name('profile.photo.delete');

    });