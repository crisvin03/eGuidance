<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CounselorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ConcernController;
use App\Http\Controllers\AppointmentController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Profile and Settings routes (for all authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/photo', [App\Http\Controllers\ProfileController::class, 'removePhoto'])->name('profile.photo.remove');
    Route::put('/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('password.update');
    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'show'])->name('settings');
    Route::put('/settings/notifications', [App\Http\Controllers\SettingsController::class, 'updateNotifications'])->name('settings.notifications');
    Route::put('/settings/privacy', [App\Http\Controllers\SettingsController::class, 'updatePrivacy'])->name('settings.privacy');
    Route::put('/settings/counseling', [App\Http\Controllers\SettingsController::class, 'updateCounseling'])->name('settings.counseling');
});

// Student routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/concerns/create', [StudentController::class, 'createConcern'])->name('concerns.create');
    Route::post('/concerns', [StudentController::class, 'storeConcern'])->name('concerns.store');
    Route::get('/concerns', [StudentController::class, 'myConcerns'])->name('concerns.index');
    Route::get('/concerns/{concern}', [StudentController::class, 'showConcern'])->name('concerns.show');
    Route::get('/appointments/create', [StudentController::class, 'createAppointment'])->name('appointments.create');
    Route::post('/appointments', [StudentController::class, 'storeAppointment'])->name('appointments.store');
    Route::get('/appointments', [StudentController::class, 'myAppointments'])->name('appointments.index');
    Route::get('/appointments/{appointment}', [StudentController::class, 'showAppointment'])->name('appointments.show');
    Route::put('/appointments/{appointment}/reschedule', [StudentController::class, 'rescheduleAppointment'])->name('appointments.reschedule');
    Route::put('/appointments/{appointment}/cancel', [StudentController::class, 'cancelAppointment'])->name('appointments.cancel');
    Route::get('/resources', [StudentController::class, 'resources'])->name('resources');
});

// Counselor routes
Route::middleware(['auth', 'role:counselor'])->prefix('counselor')->name('counselor.')->group(function () {
    Route::get('/dashboard', [CounselorController::class, 'dashboard'])->name('dashboard');
    Route::get('/concerns', [CounselorController::class, 'concerns'])->name('concerns.index');
    Route::get('/concerns/{concern}', [CounselorController::class, 'showConcern'])->name('concerns.show');
    Route::post('/concerns/{concern}/respond', [CounselorController::class, 'respondToConcern'])->name('concerns.respond');
    Route::get('/appointments', [CounselorController::class, 'appointments'])->name('appointments.index');
    Route::get('/appointments/{appointment}', [CounselorController::class, 'showAppointment'])->name('appointments.show');
    Route::post('/appointments/{appointment}/respond', [CounselorController::class, 'respondToAppointment'])->name('appointments.respond');
    Route::get('/appointments/{appointment}/session-notes/create', [CounselorController::class, 'createSessionNote'])->name('appointments.session-notes.create');
    Route::post('/appointments/{appointment}/session-notes', [CounselorController::class, 'storeSessionNote'])->name('appointments.session-notes.store');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::post('/users/{user}/deactivate', [AdminController::class, 'deactivateUser'])->name('users.deactivate');
    Route::post('/users/{user}/activate', [AdminController::class, 'activateUser'])->name('users.activate');
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories.index');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports.index');
    Route::get('/reports/export/concerns', [AdminController::class, 'exportConcerns'])->name('reports.export.concerns');
    Route::get('/reports/export/appointments', [AdminController::class, 'exportAppointments'])->name('reports.export.appointments');
    Route::get('/reports/export/users', [AdminController::class, 'exportUsers'])->name('reports.export.users');
    Route::get('/reports/export/full', [AdminController::class, 'exportFullReport'])->name('reports.export.full');
});
