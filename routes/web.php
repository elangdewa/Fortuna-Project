<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CreateMemberController;
use App\Http\Controllers\Admin\AdminMemberController;
use App\Http\Controllers\Admin\PaketMemberController;
use App\Http\Controllers\Admin\FitnessClassController;
use App\Http\Controllers\Admin\TrainerController;
use App\Http\Controllers\Admin\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Halaman lainnya
Route::view('/Fitness', 'Fitness');
Route::view('/about', 'about');
Route::view('/membership', 'membership');

// Login
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Auth::routes();

// Setelah login (default/fallback)
Route::get('/user.home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Dashboard admin dan member
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/member/dashboard', [MemberController::class, 'index'])->name('member.dashboard');
});



Route::get('/home', [MemberController::class, 'index'])->name('member.dashboard');
Route::get('/admin/members/view', [AdminController::class, 'members'])->name('members.view');
Route::get('/admin/paket', [AdminController::class, 'paket'])->name('paket.index');
Route::get('/admin/coach', [AdminController::class, 'coach'])->name('coach.index');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.admin');
});


Route::get('/admin/members/create', [AdminMemberController::class, 'create'])->name('members.create');
Route::post('/admin/members/store', [AdminMemberController::class, 'store'])->name('admin.members.store');


Route::get('/admin/members/{id}/edit', [AdminMemberController::class, 'edit'])->name('admin.members.edit');
Route::put('/admin/members/{id}', [AdminMemberController::class, 'update'])->name('admin.members.update');
Route::delete('/admin/members/{id}', [AdminMemberController::class, 'destroy'])->name('admin.members.destroy');
Route::get('/admin/members/view', [AdminMemberController::class, 'index'])->name('members.view');


Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('paketmember', PaketMemberController::class);
});

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function() {
    Route::get('/fitness', [FitnessClassController::class, 'index'])->name('fitness.index');
    Route::post('/fitness/store', [FitnessClassController::class, 'store'])->name('fitness.store');
    Route::put('/fitness/update/{id}', [FitnessClassController::class, 'update'])->name('fitness.update');
    Route::delete('/fitness/delete/{id}', [FitnessClassController::class, 'destroy'])->name('fitness.destroy');
});


Route::prefix('admin')->name('admin.')->middleware('auth')->group(function() {
    // Menampilkan daftar trainers
    Route::get('/trainers', [TrainerController::class, 'index'])->name('trainers.index');
    Route::post('/trainers', [TrainerController::class, 'store'])->name('trainers.store');

// Mengupdate trainer
Route::put('/trainers/update/{id}', [TrainerController::class, 'update'])->name('trainers.update');
    Route::put('/admin/trainers/{id}', [TrainerController::class, 'update'])->name('admin.trainers.update');
    Route::put('/admin/fitness/update/{id}', [FitnessClassController::class, 'update'])->name('admin.fitness.update');
    Route::delete('/trainers/delete/{id}', [TrainerController::class, 'destroy'])->name('trainers.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('admin.profile');
    Route::post('/profile/update-username', [ProfileController::class, 'updateUsername'])->name('admin.update.username');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('admin.update.password');
});