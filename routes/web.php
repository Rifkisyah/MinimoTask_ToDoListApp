<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ToDoItemController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Password;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// landing page
Route::get('/', fn() => view('user.index'))->name('landing-page');

// ================================================ auth ====================================================================

// Admin routes
Route::get('/admin', fn() => redirect()->route('admin.login'));
Route::view('/admin/login', 'admin.auth.login')->name('admin.login');
Route::view('/admin/register', 'admin.auth.register')->name('admin.register');
Route::view('/admin/forgot-password', 'admin.auth.forgot-password')->name('admin.forgot-password');

Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard')->middleware('auth:admin');
Route::get('/user/home', fn() => view('user.home'))->name('user.home')->middleware('auth:user');

// User routes
Route::get('/user', fn() => view('user.index'));
Route::view('/user/login', 'user.auth.login')->name('user.login');
Route::view('/user/register', 'user.auth.register')->name('user.register');
Route::view('/user/home', 'user.home')->name('user.home');

Route::post('/user/register', [AuthController::class, 'register'])->name('user.register.post');
Route::post('/user/login', [AuthController::class, 'login'])->name('user.login.post');
Route::post('/user/logout', [AuthController::class, 'logout'])->name('user.logout');

// =========================================== forgot password ==========================================================

// Form untuk input email
Route::get('/user/forgot-password', function () {
    return view('user.auth.forgot-password');
})->middleware('guest')->name('user.forgot-password');

// Proses kirim email reset
Route::post('/user/forgot-password', function (Illuminate\Http\Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = \Illuminate\Support\Facades\Password::sendResetLink(
        $request->only('email')
    );

    return back()->with('status', __($status));
})->middleware('guest')->name('password.email');

// Form reset password dari link email
Route::get('/user/reset-password/{token}', function ($token) {
    return view('user.auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

// Proses reset password
Route::post('/user/reset-password', function (Illuminate\Http\Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = \Illuminate\Support\Facades\Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => \Illuminate\Support\Facades\Hash::make($password)
            ])->save();

            event(new Illuminate\Auth\Events\PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('user.login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

// ================================================ model ====================================================================

// Route::get('/user/todos', [ToDoItemController::class, 'index'])->name('user.todos.index');
Route::get('/user/home', [ToDoItemController::class, 'home'])->name('user.home');


