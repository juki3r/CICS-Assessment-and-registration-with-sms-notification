<?php

use App\Mail\GeneralNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubAdminController;
use App\Http\Controllers\BSCSStudentController;
use App\Http\Controllers\BLISStudentsController;
use App\Http\Controllers\BSITStudentsController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\ScoringPercentageController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    if (session()->has('student_name')) {
        return redirect()->route('student.dashboard');
    }
    return view('auth.navigator');
})->name('navigator');


Route::post('/student/login', [StudentController::class, 'login'])->name('student.login');
Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
Route::post('/student/logout', [StudentController::class, 'logout'])->name('student.logout');
Route::get('/exam/{name}', [ExamController::class, 'start'])->name('exam.start');
Route::post('/exam/submit/{name}', [ExamController::class, 'submit'])->name('exam.submit');




// ADMIN
Route::get('/admin/register', [AdminController::class, 'register'])->name('admin.register');
Route::post('/admin/register', [AdminController::class, 'register_save'])->name('admin.register.save');
Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login_proceed'])->name('admin.login.proceed');

Route::middleware(['auth:admin'])->group(function () {
    //Checked ----------------------------------------------------------------------------------------
    Route::get('/admin/users', [AdminController::class, 'admin_users'])->name('admin.users');
    Route::post('/admin/users', [AdminController::class, 'admin_users_add'])->name('add.admin.user');
    Route::get('/subadmin/delete/{id}', [AdminController::class, 'delete'])->name('subadmin.delete');
    Route::get('/admin/users/search', [AdminController::class, 'search'])->name('admin.users.search');

    // ------------------------------------------------------------------------------------------------

    //Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');


    //Registrations
    Route::get('/admin/registrations', [AdminController::class, 'admin_registrations'])->name('admin.registrations');
    Route::get('/admin/registrations/search', [AdminController::class, 'admin_registrations'])->name('admin.registrations.search');
    Route::post('/admin/registrations/add', [AdminController::class, 'admin_registrations_add'])->name('add.registration');
    Route::get('/student/delete/{id}', [AdminController::class, 'delete_student'])->name('student.delete');




    //Questionaires
    Route::resource('questions', \App\Http\Controllers\Admin\QuestionController::class);
    Route::get('/admin/questionaire', [QuestionController::class, 'index'])->name('show.questions');




    Route::get('/admin-notification', [AdminController::class, 'admin_notification'])->name('admin.notification');
    Route::get('admin/notification/{id}/{category}/{user_id}', [AdminController::class, 'showNotification'])->name('admin.notification.show');
    Route::get('/admin-approval', [AdminController::class, 'admin_approval'])->name('admin.approval');
    Route::get('/admin_student_details/{id}', [AdminController::class, 'admin_student_details'])->name('admin.newstudent.show.student');
    Route::post('/admin_approved_student/{id}', [AdminController::class, 'admin_approved_student'])->name('approve.student');
    Route::post('/admin_denied_student/{id}', [AdminController::class, 'admin_denied_student'])->name('deny.student');
    Route::get('/students/{course}', [AdminController::class, 'show_students'])->name('students');
    Route::get('/exam_results/{course}', [AdminController::class, 'show_exam_results'])->name('exam_results');
    Route::post('/admin/update-exam-field', [AdminController::class, 'updateExamField'])->name('admin.update_exam_field');




    //Entrance exam
    Route::get('/entrance_exam', [AdminController::class, 'entrance_exam'])->name('entrance_exam');
    Route::post('/save_passed_student', [AdminController::class, 'save_passed_student'])->name('save_passed_student');
    Route::get('/entrance-exam/delete/{id}', [AdminController::class, 'delete_entrance'])->name('delete_entrance_student');
    Route::get('/interview', [AdminController::class, 'interview'])->name('interview');

    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');

    Route::get('/smslogs', [AdminController::class, 'smslogs'])->name('smslogs.logs');
    Route::get('/sent', [AdminController::class, 'sent'])->name('smslogs.sent');

    // Route::get('/send/sms', [AdminController::class, 'sendSmsFromClient'])->name('sendSmsFromClient');
    Route::post('/send/sms', [AdminController::class, 'sendSmsFromClient'])->name('sendSmsFromClient');
    Route::post('/edit/timer', [AdminController::class, 'editTimer'])->name('edit.timer');

    //Archives
    Route::get('/archives', [AdminController::class, 'archives'])->name('archives');

    //Notiffications
    Route::get('/admin/notifications', [AdminController::class, 'notifications'])->name('admin.notifications');
    Route::post('/admin/notifications/{id}/mark-read', [AdminController::class, 'markNotificationRead'])->name('admin.notifications.markRead');


    Route::get('/scoring', [ScoringPercentageController::class, 'index'])->name('scoring.index');
    Route::post('/scoring', [ScoringPercentageController::class, 'update'])->name('scoring.update');
});

Route::get('/admin/interview', [AdminController::class, 'interview'])->name('admin.interview');
Route::put('/registrations/{id}/interview-result', [AdminController::class, 'updateInterviewResult'])
    ->name('registrations.updateInterviewResult');

Route::get('/admin/skilltest', [AdminController::class, 'skilltest'])->name('admin.skilltest');
Route::put('/registrations/{id}/skilltest', [AdminController::class, 'updateSkilltest'])
    ->name('registrations.updateSkilltest');

Route::post('/student/logout', [StudentController::class, 'logout'])->name('student.logout');




//SUBADMIN/ FACULTY
Route::get('/subadmin/login', [SubAdminController::class, 'index']);
Route::post('/subadmin/login', [SubAdminController::class, 'login'])->name('subadmin.login');

Route::get('/subadmin/dashboard', [SubAdminController::class, 'dashboard'])->name('subadmin.dashboard');



// Admin routes (already exist)
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Subadmin routes
Route::post('/subadmin/logout', [SubAdminController::class, 'logout'])->name('subadmin.logout');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
