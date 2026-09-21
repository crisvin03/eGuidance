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

// Pending approval page (public, no auth required)
Route::get('/approval-pending', fn() => view('auth.approval-pending'))->name('approval.pending');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Profile and Settings routes (for all authenticated users)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/photo', [App\Http\Controllers\ProfileController::class, 'removePhoto'])->name('profile.photo.remove');
    Route::put('/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'show'])->name('settings');
    Route::put('/settings/notifications', [App\Http\Controllers\SettingsController::class, 'updateNotifications'])->name('settings.notifications');
    Route::put('/settings/privacy', [App\Http\Controllers\SettingsController::class, 'updatePrivacy'])->name('settings.privacy');
    Route::put('/settings/counseling', [App\Http\Controllers\SettingsController::class, 'updateCounseling'])->name('settings.counseling');
    
    // Messaging System (All authenticated users)
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [App\Http\Controllers\MessagingController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\MessagingController::class, 'create'])->name('create');
        Route::post('/send', [App\Http\Controllers\MessagingController::class, 'store'])->name('store');
        Route::get('/conversation/{userId}', [App\Http\Controllers\MessagingController::class, 'show'])->name('show');
        Route::get('/new/{conversationId}/{lastMessageId?}', [App\Http\Controllers\MessagingController::class, 'getNewMessages'])->name('new');
        Route::post('/read/{conversationId}', [App\Http\Controllers\MessagingController::class, 'markAsRead'])->name('read');
        Route::get('/unread-count', [App\Http\Controllers\MessagingController::class, 'unreadCount'])->name('unread-count');
        Route::get('/search-users', [App\Http\Controllers\MessagingController::class, 'searchUsers'])->name('search-users');
        
        // Message actions
        Route::put('/{messageId}/edit', [App\Http\Controllers\MessagingController::class, 'editMessage'])->name('edit');
        Route::delete('/{messageId}/unsend', [App\Http\Controllers\MessagingController::class, 'unsendMessage'])->name('unsend');
        Route::post('/{messageId}/react', [App\Http\Controllers\MessagingController::class, 'reactToMessage'])->name('react');
        
        // Conversation actions
        Route::post('/clear/{conversationId}', [App\Http\Controllers\MessagingController::class, 'clearConversation'])->name('clear');
        Route::delete('/delete/{conversationId}', [App\Http\Controllers\MessagingController::class, 'deleteConversation'])->name('delete');
    });
});

// Student routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    
    // Legacy concerns routes - redirect to Spill the Tea
    Route::get('/concerns/create', function() {
        return redirect()->route('student.spill-tea');
    })->name('concerns.create');
    Route::get('/concerns', [StudentController::class, 'myConcerns'])->name('concerns.index');
    Route::get('/concerns/{concern}', [StudentController::class, 'showConcern'])->name('concerns.show');
    
    // Spill the Tea (Enhanced Concerns)
    Route::get('/spill-tea', [StudentController::class, 'spillTea'])->name('spill-tea');
    Route::post('/spill-tea', [StudentController::class, 'spillTeaStore'])->name('spill-tea.store');
    
    // Connect with Ate/Kuya (Enhanced Appointments + Messaging)
    Route::get('/connect', [StudentController::class, 'connect'])->name('connect');
    Route::get('/connect/counselors', [StudentController::class, 'connectCounselors'])->name('connect.counselors');
    Route::get('/connect/chat/{user}', [StudentController::class, 'chat'])->name('connect.chat');
    Route::post('/connect/message', [StudentController::class, 'sendMessage'])->name('connect.message');
    Route::get('/connect/appointments', [StudentController::class, 'connectAppointments'])->name('connect.appointments');
    Route::post('/connect/appointments', [StudentController::class, 'bookAppointment'])->name('connect.appointments.store');
    
    // Legacy appointments routes (for backward compatibility)
    Route::get('/appointments/create', [StudentController::class, 'createAppointment'])->name('appointments.create');
    Route::post('/appointments', [StudentController::class, 'storeAppointment'])->name('appointments.store');
    Route::get('/appointments', [StudentController::class, 'myAppointments'])->name('appointments.index');
    Route::get('/appointments/{appointment}', [StudentController::class, 'showAppointment'])->name('appointments.show');
    Route::put('/appointments/{appointment}/reschedule', [StudentController::class, 'rescheduleAppointment'])->name('appointments.reschedule');
    Route::put('/appointments/{appointment}/cancel', [StudentController::class, 'cancelAppointment'])->name('appointments.cancel');
    
    // Mind Check (Mental Health Assessments)
    Route::get('/mind-check', [StudentController::class, 'mindCheck'])->name('mind-check');
    Route::get('/mind-check/headss', [StudentController::class, 'headssAssessment'])->name('mind-check.headss');
    Route::post('/mind-check/headss', [StudentController::class, 'storeHeadss'])->name('mind-check.headss.store');
    Route::get('/mind-check/gad7', [StudentController::class, 'gad7Assessment'])->name('mind-check.gad7');
    Route::post('/mind-check/gad7', [StudentController::class, 'storeGad7'])->name('mind-check.gad7.store');
    Route::get('/mind-check/phq9', [StudentController::class, 'phq9Assessment'])->name('mind-check.phq9');
    Route::post('/mind-check/phq9', [StudentController::class, 'storePhq9'])->name('mind-check.phq9.store');
    Route::get('/mind-check/submitted', [StudentController::class, 'mindCheckSubmitted'])->name('mind-check.submitted');
    Route::get('/mind-check/results/{assessment}', [StudentController::class, 'mindCheckResults'])->name('mind-check.results');
    Route::get('/mind-check/history', [StudentController::class, 'mindCheckHistory'])->name('mind-check.history');
    
    // Other features
    Route::get('/resources', [StudentController::class, 'resources'])->name('resources');
    Route::get('/kamusta-ka', [StudentController::class, 'kamustaka'])->name('kamustaka');
    Route::post('/kamusta-ka', [StudentController::class, 'storeKamustaka'])->name('kamustaka.store');
    Route::get('/kamusta-ka/support', [StudentController::class, 'kamustakaSupportPage'])->name('kamustaka.support');
    Route::get('/forms', [StudentController::class, 'formGenerator'])->name('forms.index');
    Route::get('/virtual-id', [StudentController::class, 'virtualId'])->name('virtual-id');
    
    // Resources & Community Hub (unified page)
    Route::get('/resources', [StudentController::class, 'resourcesIndex'])->name('resources.index');
    
    // Redirect individual feature routes to unified page
    Route::get('/new-here', [StudentController::class, 'newHere'])->name('new-here');
    Route::get('/new-here/form', [StudentController::class, 'newHereForm'])->name('new-here.form');
    Route::post('/new-here/submit', [StudentController::class, 'storeNewHere'])->name('new-here.submit');
    Route::get('/new-here/view/{id}', [StudentController::class, 'viewNewHere'])->name('new-here.view');
    Route::get('/real-talk', [StudentController::class, 'realTalk'])->name('real-talk');
    Route::get('/unfiltered', [StudentController::class, 'unfiltered'])->name('unfiltered');
    Route::get('/find-people', [StudentController::class, 'findPeople'])->name('find-people');
    Route::get('/exit-check', [StudentController::class, 'exitCheck'])->name('exit-check');
    Route::get('/future-me', [StudentController::class, 'futureMe'])->name('future-me');
    
    // Student Forms
    Route::get('/forms', [StudentController::class, 'formsIndex'])->name('forms.index');
    Route::get('/forms/{type}', [StudentController::class, 'showFormType'])->name('forms.show');
    Route::post('/forms/submit', [StudentController::class, 'submitForm'])->name('forms.submit');
    Route::get('/forms/view/{submission}', [StudentController::class, 'viewSubmission'])->name('forms.view');
    
    // Creative Submissions (Poetry, Artwork, Photography)
    Route::prefix('submissions')->name('submissions.')->group(function () {
        Route::get('/', [StudentController::class, 'submissionsIndex'])->name('index');
        Route::get('/create', [StudentController::class, 'createSubmission'])->name('create');
        Route::post('/', [StudentController::class, 'storeSubmission'])->name('store');
        Route::get('/{submission}', [StudentController::class, 'showSubmission'])->name('show');
        Route::get('/my-submissions', [StudentController::class, 'mySubmissions'])->name('my-submissions');
        Route::delete('/{submission}', [StudentController::class, 'destroySubmission'])->name('destroy');
    });
});

// Counselor routes
Route::middleware(['auth', 'role:counselor'])->prefix('counselor')->name('counselor.')->group(function () {
    Route::get('/dashboard', [CounselorController::class, 'dashboard'])->name('dashboard');
    Route::get('/concerns', [CounselorController::class, 'concerns'])->name('concerns.index');
    Route::get('/concerns/{concern}', [CounselorController::class, 'showConcern'])->name('concerns.show');
    Route::post('/concerns/{concern}/respond', [CounselorController::class, 'respondToConcern'])->name('concerns.respond');
    Route::put('/concerns/{concern}/update', [CounselorController::class, 'updateConcern'])->name('concerns.update');
    Route::delete('/concerns/{concern}', [CounselorController::class, 'destroyConcern'])->name('concerns.destroy');
    Route::post('/concerns/{concern}/add-note', [CounselorController::class, 'addConcernNote'])->name('concerns.add-note');
    Route::get('/concerns/{concern}/notes', [CounselorController::class, 'viewConcernNotes'])->name('concerns.notes');
    Route::get('/appointments', [CounselorController::class, 'appointments'])->name('appointments.index');
    Route::get('/appointments/{appointment}', [CounselorController::class, 'showAppointment'])->name('appointments.show');
    Route::post('/appointments', [CounselorController::class, 'storeAppointment'])->name('appointments.store');
    Route::post('/appointments/{appointment}/respond', [CounselorController::class, 'respondToAppointment'])->name('appointments.respond');
    Route::get('/appointments/{appointment}/session-notes/create', [CounselorController::class, 'createSessionNote'])->name('appointments.session-notes.create');
    Route::post('/appointments/{appointment}/session-notes', [CounselorController::class, 'storeSessionNote'])->name('appointments.session-notes.store');
    Route::get('/incident-reports', [CounselorController::class, 'incidentReports'])->name('incident-reports.index');
    Route::get('/incident-reports/{incidentReport}', [CounselorController::class, 'showIncidentReport'])->name('incident-reports.show');
    Route::post('/incident-reports/{incidentReport}/update', [CounselorController::class, 'updateIncidentReport'])->name('incident-reports.update');
    Route::delete('/incident-reports/{incidentReport}', [CounselorController::class, 'destroyIncidentReport'])->name('incident-reports.destroy');
    Route::get('/incident-reports/{incidentReport}/print', [CounselorController::class, 'printIncidentReport'])->name('incident-reports.print');
    Route::get('/referrals', [CounselorController::class, 'referrals'])->name('referrals.index');
    Route::get('/referrals/{studentReferral}', [CounselorController::class, 'showReferral'])->name('referrals.show');
    Route::post('/referrals/{studentReferral}/update', [CounselorController::class, 'updateReferral'])->name('referrals.update');
    Route::delete('/referrals/{studentReferral}', [CounselorController::class, 'destroyReferral'])->name('referrals.destroy');
    Route::get('/referrals/{studentReferral}/print', [CounselorController::class, 'printReferral'])->name('referrals.print');
    Route::post('/referrals/{studentReferral}/update', [CounselorController::class, 'updateReferral'])->name('referrals.update');
    Route::delete('/referrals/{studentReferral}', [CounselorController::class, 'destroyReferral'])->name('referrals.destroy');
    Route::get('/forms', [CounselorController::class, 'formGenerator'])->name('forms.index');
    Route::get('/forms/submitted', [CounselorController::class, 'submittedForms'])->name('forms.submitted');
    Route::get('/forms/submitted/{submission}', [CounselorController::class, 'showSubmittedForm'])->name('forms.submitted.show');
    Route::get('/forms/submitted/{submission}/print', [CounselorController::class, 'printSubmittedForm'])->name('forms.submitted.print');
    Route::post('/forms/submitted/{submission}/review', [CounselorController::class, 'reviewForm'])->name('forms.submitted.review');
    Route::delete('/forms/submitted/{submission}', [CounselorController::class, 'destroySubmission'])->name('forms.submitted.destroy');
    
    // Mental Health Assessments
    Route::get('/mental-health', [CounselorController::class, 'mentalHealthAssessments'])->name('mental-health.index');
    Route::get('/mental-health/{assessment}', [CounselorController::class, 'showMentalHealthAssessment'])->name('mental-health.show');
    Route::put('/mental-health/{assessment}', [CounselorController::class, 'updateMentalHealthAssessment'])->name('mental-health.update');
    
    // Student Form Submissions
    Route::get('/student-forms', [CounselorController::class, 'studentForms'])->name('student-forms.index');
    Route::get('/student-forms/{submission}', [CounselorController::class, 'showStudentForm'])->name('student-forms.show');
    Route::get('/student-forms/{submission}/print', [CounselorController::class, 'printStudentForm'])->name('student-forms.print');
    Route::put('/student-forms/{submission}/review', [CounselorController::class, 'reviewStudentForm'])->name('student-forms.review');
    
    // Calendar
    Route::get('/calendar', [CounselorController::class, 'calendar'])->name('calendar');
    Route::get('/calendar/events', [CounselorController::class, 'calendarEvents'])->name('calendar.events');
    
    // Resources & Community
    Route::get('/resources-community', [CounselorController::class, 'resourcesCommunity'])->name('resources-community');
    
    // Teacher Resources Management
    Route::prefix('resources')->name('resources.')->group(function () {
        Route::get('/', [CounselorController::class, 'resourcesIndex'])->name('index');
        Route::get('/create', [CounselorController::class, 'createResource'])->name('create');
        Route::post('/', [CounselorController::class, 'storeResource'])->name('store');
        Route::get('/{resource}', [CounselorController::class, 'showResource'])->name('show');
        Route::get('/{resource}/download', [CounselorController::class, 'downloadResource'])->name('download');
        Route::delete('/{resource}', [CounselorController::class, 'destroyResource'])->name('destroy');
        Route::put('/{resource}/toggle-status', [CounselorController::class, 'toggleResourceStatus'])->name('toggle-status');
    });
    
    // Student Submissions Management
    Route::prefix('student-submissions')->name('student-submissions.')->group(function () {
        Route::get('/', [CounselorController::class, 'studentSubmissionsIndex'])->name('index');
        Route::get('/{submission}', [CounselorController::class, 'showStudentSubmission'])->name('show');
        Route::put('/{submission}/review', [CounselorController::class, 'reviewStudentSubmission'])->name('review');
        Route::get('/{submission}/download', [CounselorController::class, 'downloadStudentSubmission'])->name('download');
        Route::put('/{submission}/toggle-featured', [CounselorController::class, 'toggleFeaturedSubmission'])->name('toggle-featured');
        Route::delete('/{submission}', [CounselorController::class, 'destroyStudentSubmission'])->name('destroy');
    });
    
    // Account approvals
    Route::get('/pending-accounts', [CounselorController::class, 'pendingAccounts'])->name('pending-accounts');
    Route::post('/pending-accounts/{user}/approve', [CounselorController::class, 'approveAccount'])->name('pending-accounts.approve');
    Route::delete('/pending-accounts/{user}/reject', [CounselorController::class, 'rejectAccount'])->name('pending-accounts.reject');
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
    Route::delete('/forms/my-submissions/{submission}', [App\Http\Controllers\TeacherController::class, 'destroyFormSubmission'])->name('forms.submissions.destroy');
    Route::get('/case-tracking', [App\Http\Controllers\TeacherController::class, 'caseTracking'])->name('case-tracking.index');
    Route::get('/intervention-guides', [App\Http\Controllers\TeacherController::class, 'interventionGuides'])->name('intervention-guides.index');
    Route::get('/talk-to-counselor', [App\Http\Controllers\TeacherController::class, 'talkToCounselor'])->name('talk-to-counselor');
    Route::post('/appointments', [App\Http\Controllers\TeacherController::class, 'storeAppointment'])->name('appointments.store');
    Route::get('/appointments', [App\Http\Controllers\TeacherController::class, 'myAppointments'])->name('appointments.index');
    Route::get('/appointments/{appointment}', [App\Http\Controllers\TeacherController::class, 'showAppointment'])->name('appointments.show');
    Route::get('/virtual-id', [App\Http\Controllers\TeacherController::class, 'virtualId'])->name('virtual-id');
    Route::get('/resources', [App\Http\Controllers\TeacherController::class, 'resources'])->name('resources');
    
    // Teacher Resources Access
    Route::prefix('resources')->name('resources.')->group(function () {
        Route::get('/hrg', [App\Http\Controllers\TeacherController::class, 'hrgResources'])->name('hrg');
        Route::get('/handbook', [App\Http\Controllers\TeacherController::class, 'handbookResources'])->name('handbook');
        Route::get('/gender-dev', [App\Http\Controllers\TeacherController::class, 'genderDevResources'])->name('gender-dev');
        Route::get('/{resource}/download', [App\Http\Controllers\TeacherController::class, 'downloadResource'])->name('download');
    });
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
    Route::get('/reports/export/concerns', [AdminController::class, 'exportConcerns'])->name('reports.export.concerns')->middleware('throttle:10,1');
    Route::get('/reports/export/appointments', [AdminController::class, 'exportAppointments'])->name('reports.export.appointments')->middleware('throttle:10,1');
    Route::get('/reports/export/users', [AdminController::class, 'exportUsers'])->name('reports.export.users')->middleware('throttle:10,1');
    Route::get('/reports/export/full', [AdminController::class, 'exportFullReport'])->name('reports.export.full')->middleware('throttle:10,1');
});
