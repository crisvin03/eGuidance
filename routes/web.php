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
    Route::get('/kamusta-ka', [StudentController::class, 'kamustaka'])->name('kamustaka');
    Route::post('/kamusta-ka', [StudentController::class, 'storeKamustaka'])->name('kamustaka.store');
    Route::get('/kamusta-ka/support', [StudentController::class, 'kamustakaSupportPage'])->name('kamustaka.support');
    Route::get('/forms', [StudentController::class, 'formGenerator'])->name('forms.index');
    Route::get('/virtual-id', [StudentController::class, 'virtualId'])->name('virtual-id');
});

// Counselor routes
Route::middleware(['auth', 'role:counselor'])->prefix('counselor')->name('counselor.')->group(function () {
    Route::get('/dashboard', [CounselorController::class, 'dashboard'])->name('dashboard');
    Route::get('/concerns', [CounselorController::class, 'concerns'])->name('concerns.index');
    Route::get('/concerns/{concern}', [CounselorController::class, 'showConcern'])->name('concerns.show');
    Route::post('/concerns/{concern}/respond', [CounselorController::class, 'respondToConcern'])->name('concerns.respond');
    Route::put('/concerns/{concern}/update', [CounselorController::class, 'updateConcern'])->name('concerns.update');
    Route::delete('/concerns/{concern}', [CounselorController::class, 'destroyConcern'])->name('concerns.destroy');
    Route::get('/appointments', [CounselorController::class, 'appointments'])->name('appointments.index');
    Route::get('/appointments/{appointment}', [CounselorController::class, 'showAppointment'])->name('appointments.show');
    Route::post('/appointments/{appointment}/respond', [CounselorController::class, 'respondToAppointment'])->name('appointments.respond');
    Route::get('/appointments/{appointment}/session-notes/create', [CounselorController::class, 'createSessionNote'])->name('appointments.session-notes.create');
    Route::post('/appointments/{appointment}/session-notes', [CounselorController::class, 'storeSessionNote'])->name('appointments.session-notes.store');
    Route::get('/incident-reports', [CounselorController::class, 'incidentReports'])->name('incident-reports.index');
    Route::get('/incident-reports/{incidentReport}', [CounselorController::class, 'showIncidentReport'])->name('incident-reports.show');
    Route::post('/incident-reports/{incidentReport}/update', [CounselorController::class, 'updateIncidentReport'])->name('incident-reports.update');
    Route::delete('/incident-reports/{incidentReport}', [CounselorController::class, 'destroyIncidentReport'])->name('incident-reports.destroy');
    Route::get('/referrals', [CounselorController::class, 'referrals'])->name('referrals.index');
    Route::get('/referrals/{studentReferral}', [CounselorController::class, 'showReferral'])->name('referrals.show');
    Route::post('/referrals/{studentReferral}/update', [CounselorController::class, 'updateReferral'])->name('referrals.update');
    Route::delete('/referrals/{studentReferral}', [CounselorController::class, 'destroyReferral'])->name('referrals.destroy');
    Route::get('/forms', [CounselorController::class, 'formGenerator'])->name('forms.index');
    Route::get('/forms/submitted', [CounselorController::class, 'submittedForms'])->name('forms.submitted');
    Route::get('/forms/submitted/{submission}', [CounselorController::class, 'showSubmittedForm'])->name('forms.submitted.show');
    Route::post('/forms/submitted/{submission}/review', [CounselorController::class, 'reviewForm'])->name('forms.submitted.review');
});

// Teacher routes
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\TeacherController::class, 'dashboard'])->name('dashboard');
    Route::get('/incident-reports', [App\Http\Controllers\TeacherController::class, 'incidentReports'])->name('incident-reports.index');
    Route::get('/incident-reports/create', [App\Http\Controllers\TeacherController::class, 'createIncidentReport'])->name('incident-reports.create');
    Route::post('/incident-reports', [App\Http\Controllers\TeacherController::class, 'storeIncidentReport'])->name('incident-reports.store');
    Route::get('/incident-reports/{incidentReport}', [App\Http\Controllers\TeacherController::class, 'showIncidentReport'])->name('incident-reports.show');
    Route::delete('/incident-reports/{incidentReport}', [App\Http\Controllers\TeacherController::class, 'destroyIncidentReport'])->name('incident-reports.destroy');
    Route::get('/referrals', [App\Http\Controllers\TeacherController::class, 'referrals'])->name('referrals.index');
    Route::get('/referrals/create', [App\Http\Controllers\TeacherController::class, 'createReferral'])->name('referrals.create');
    Route::post('/referrals', [App\Http\Controllers\TeacherController::class, 'storeReferral'])->name('referrals.store');
    Route::get('/referrals/{studentReferral}', [App\Http\Controllers\TeacherController::class, 'showReferral'])->name('referrals.show');
    Route::get('/forms', [App\Http\Controllers\TeacherController::class, 'formGenerator'])->name('forms.index');
    Route::post('/forms/submit', [App\Http\Controllers\TeacherController::class, 'submitForm'])->name('forms.submit');
    Route::get('/forms/my-submissions', [App\Http\Controllers\TeacherController::class, 'myFormSubmissions'])->name('forms.submissions');
    Route::get('/forms/my-submissions/{submission}', [App\Http\Controllers\TeacherController::class, 'showFormSubmission'])->name('forms.submissions.show');
    Route::get('/case-tracking', [App\Http\Controllers\TeacherController::class, 'caseTracking'])->name('case-tracking.index');
    Route::get('/intervention-guides', [App\Http\Controllers\TeacherController::class, 'interventionGuides'])->name('intervention-guides.index');
    Route::get('/talk-to-counselor', [App\Http\Controllers\TeacherController::class, 'talkToCounselor'])->name('talk-to-counselor');
    Route::post('/appointments', [App\Http\Controllers\TeacherController::class, 'storeAppointment'])->name('appointments.store');
    Route::get('/appointments', [App\Http\Controllers\TeacherController::class, 'myAppointments'])->name('appointments.index');
    Route::get('/appointments/{appointment}', [App\Http\Controllers\TeacherController::class, 'showAppointment'])->name('appointments.show');
    Route::get('/virtual-id', [App\Http\Controllers\TeacherController::class, 'virtualId'])->name('virtual-id');
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
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories.index');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports.index');
    Route::get('/reports/export/concerns', [AdminController::class, 'exportConcerns'])->name('reports.export.concerns');
    Route::get('/reports/export/appointments', [AdminController::class, 'exportAppointments'])->name('reports.export.appointments');
    Route::get('/reports/export/users', [AdminController::class, 'exportUsers'])->name('reports.export.users');
    Route::get('/reports/export/full', [AdminController::class, 'exportFullReport'])->name('reports.export.full');
});
