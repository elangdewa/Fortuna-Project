<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CreateMemberController;
use App\Http\Controllers\Admin\AdminMemberController;
use App\Http\Controllers\Admin\PaketMemberController;
use App\Http\Controllers\Admin\FitnessClassController;
use App\Http\Controllers\Admin\TrainerController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\Admin\TrainerOrderController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\FitnessScheduleController;
use App\Http\Controllers\UserTrainerOrderController;
use App\Http\Controllers\UserTrainerController;
use App\Http\Controllers\FitnessRegistrationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\SuperAdmin\AdminManagementController;
use App\Http\Controllers\SuperAdmin\SettingsController;
use App\Http\Controllers\SuperAdmin\MemberViewController;
use App\Http\Controllers\SuperAdmin\TrainerViewController;
use App\Http\Controllers\SuperAdmin\FitnessViewController;
  use App\Http\Controllers\Admin\FitnessExportController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


Route::get('/', function () {
    return view('welcome');
});

Route::view('/Fitness', 'Fitness');
Route::view('/about', 'about');
Route::view('/membership', 'membership');

Auth::routes();
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);


Route::middleware(['auth', 'admin', 'prevent-back'])->prefix('admin')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/', [AdminController::class, 'index'])->name('admin.admin');


    Route::get('/paketmember', [PaketMemberController::class, 'index'])->name('admin.paketmember.index');
    Route::get('/paketmember/create', [PaketMemberController::class, 'create'])->name('admin.paketmember.create');
    Route::post('/paketmember', [PaketMemberController::class, 'store'])->name('admin.paketmember.store');
    Route::get('/paketmember/{paketmember}/edit', [PaketMemberController::class, 'edit'])->name('admin.paketmember.edit');
    Route::put('/paketmember/{paketmember}', [PaketMemberController::class, 'update'])->name('admin.paketmember.update');
    Route::delete('/paketmember/{paketmember}', [PaketMemberController::class, 'destroy'])->name('admin.paketmember.destroy');

    // Members Management
    Route::get('/members/view', [AdminMemberController::class, 'index'])->name('members.view');
    Route::get('/members/create', [AdminMemberController::class, 'create'])->name('members.create');
    Route::post('/members/store', [AdminMemberController::class, 'store'])->name('admin.members.store');
    Route::get('/members/{id}/edit', [AdminMemberController::class, 'edit'])->name('admin.members.edit');
    Route::put('/members/{id}', [AdminMemberController::class, 'update'])->name('admin.members.update');
    Route::delete('/members/{id}', [AdminMemberController::class, 'destroy'])->name('admin.members.destroy');



    // Fitness Management
Route::get('/fitness', [FitnessClassController::class, 'index'])->name('admin.fitness.index');
    Route::post('/fitness/store', [FitnessClassController::class, 'store'])->name('admin.fitness.store');
    Route::put('/fitness/update/{id}', [FitnessClassController::class, 'update'])->name('admin.fitness.update');
    Route::delete('/fitness/delete/{id}', [FitnessClassController::class, 'destroy'])->name('admin.fitness.destroy');

    // Fitness Schedules
    Route::get('/fitness/{classId}/schedules', [FitnessScheduleController::class, 'index'])->name('admin.fitness.schedules.index');
    Route::post('/fitness/{classId}/schedules', [FitnessScheduleController::class, 'store'])->name('admin.fitness.schedules.store');
    Route::put('/fitness/schedules/{scheduleId}', [FitnessScheduleController::class, 'update'])->name('admin.fitness.schedules.update');
    Route::delete('/fitness/schedules/{scheduleId}', [FitnessScheduleController::class, 'destroy'])->name('admin.fitness.schedules.destroy');
    Route::get('/fitness/schedules/{schedule}/members', [FitnessScheduleController::class, 'scheduleMembers'])
        ->name('admin.fitness.schedule.members');
    Route::put('/fitness/schedule/members/{registration}/activate', [FitnessClassController::class, 'activateMember'])
        ->name('admin.fitness.schedule.members.activate');
    Route::put('/fitness/schedule/members/{registration}/deactivate', [FitnessClassController::class, 'deactivateMember'])
        ->name('admin.fitness.schedule.members.deactivate');

    // Trainers Management
    Route::get('/trainers', [TrainerController::class, 'index'])->name('admin.trainers.index');
    Route::post('/trainers', [TrainerController::class, 'store'])->name('admin.trainers.store');
    Route::put('/trainers/update/{id}', [TrainerController::class, 'update'])->name('admin.trainers.update');
    Route::delete('/trainers/delete/{id}', [TrainerController::class, 'destroy'])->name('admin.trainers.destroy');

    // Trainer Orders
    Route::get('/trainers/orders', [TrainerOrderController::class, 'index'])->name('admin.trainer.orders');
    Route::put('/trainer-orders/{id}', [TrainerOrderController::class, 'update'])->name('admin.trainer-orders.update');
    Route::delete('/trainer-orders/{id}', [TrainerOrderController::class, 'destroy'])->name('admin.trainer-orders.destroy');

    // Admin Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('admin.profile');
    Route::post('/profile/update', [ProfileController::class, 'updateUsername'])->name('admin.profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('admin.profile.password');
});


Route::middleware(['auth', 'member', 'prevent-back'])->group(function () {
   Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/user/home', [HomeController::class, 'index'])->name('user.home');
    Route::get('/user/member', action: [HomeController::class, 'member'])->name('user.member');

    // User Settings
    Route::prefix('user')->middleware(['verified'])->group(function () {
        Route::get('/setting', [UserSettingsController::class, 'index'])->name('user.setting');
        Route::put('/setting/update', [UserSettingsController::class, 'updateProfile'])->name('user.setting.update');
        Route::post('/setting/password', [UserSettingsController::class, 'updatePassword'])->name('user.setting.password');
    });


    Route::post('/memberships', [MembershipController::class, 'store'])->name('memberships.store');
    Route::get('/memberships/create', [MembershipController::class, 'create'])->name('memberships.create');
    Route::get('/memberships', [MembershipController::class, 'create'])->name('membership.create');
    Route::post('/memberships/choose/{typeId}', [MembershipController::class, 'choosePlan'])->name('membership.choose');
    Route::post('/memberships/store', [MembershipController::class, 'store'])->name('membership.store');

    // Fitness Registration
    Route::get('/fitness/register', [FitnessRegistrationController::class, 'create'])->name('fitness.register.create');
    Route::post('/fitness/register', [FitnessRegistrationController::class, 'store'])->name('fitness.register.store');
    Route::delete('/fitness/register/{registration}', [FitnessRegistrationController::class, 'cancel'])->name('fitness.register.cancel');
    Route::get('/user/fitness', [FitnessRegistrationController::class, 'create'])->name('user.fitness');

    // Trainer Orders
    Route::get('/user/trainer', [UserTrainerController::class, 'index'])->name('user.trainer');
    Route::post('/trainer-orders', [UserTrainerOrderController::class, 'store'])->name('user.trainer-orders.store');
    Route::get('/user/trainer', [UserTrainerOrderController::class, 'showTrainerPage'])->name('user.trainer');
    Route::get('/user/trainer-orders', [UserTrainerOrderController::class, 'index'])->name('user.trainer-orders.index');
});


Route::middleware(['auth', 'superadmin', 'prevent-back'])->prefix('superadmin')->group(function () {
    Route::get('/', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');

    // Admin Management
   Route::resource('/admins', AdminManagementController::class)->names([
    'index' => 'superadmin.admins.index',
    'create' => 'superadmin.admins.create',
    'store' => 'superadmin.admins.store',
    'show' => 'superadmin.admins.show',
    'edit' => 'superadmin.admins.edit',
    'update' => 'superadmin.admins.update',
    'destroy' => 'superadmin.admins.destroy',
]);
 Route::get('/members', [MemberViewController::class, 'index'])->name('superadmin.members.index');
    Route::get('/trainers', [TrainerViewController::class, 'index'])->name('superadmin.trainers.index');
    Route::get('/fitness', [FitnessViewController::class, 'index'])->name('superadmin.fitness.index');

    // System Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('superadmin.settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('superadmin.settings.update');
});


Route::middleware(['auth'])->group(function () {
    Route::post('/payment/create', [PaymentController::class, 'createTransaction'])->name('payment.create');
    Route::get('/payment/status/{orderId}', [PaymentController::class, 'checkStatus'])->name('payment.status');
    Route::get('/payment/check/{paymentId}', [PaymentController::class, 'checkPaymentStatus'])->name('payment.check');

});

Route::post('/midtrans/notification', [PaymentController::class, 'notificationHandler']);
Route::post('/admin/schedules/generate', [FitnessScheduleController::class, 'generateInstance'])->name('admin.schedules.generate');
Route::post('/admin/generate-schedules', [FitnessScheduleController::class, 'generateInstance'])
     ->name('admin.schedules.generate');


Route::prefix('admin/export')->name('admin.export.')->group(function () {
    Route::get('/memberships', [FitnessExportController::class, 'exportMemberships'])->name('memberships');
    Route::get('/fitness/all', [FitnessExportController::class, 'exportAllClassesWithMembers'])->name('fitness.all');
    Route::get('/fitness/class', [FitnessExportController::class, 'exportSingleClass'])->name('fitness.single');

});
Route::get('/fitness/export', [FitnessExportController::class, 'showFitnessExportPage'])->name('admin.fitness.export.page');
