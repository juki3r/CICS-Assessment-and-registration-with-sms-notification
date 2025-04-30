<?php

use App\Http\Controllers\AdminController;
use App\Mail\GeneralNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BSCSStudentController;
use App\Http\Controllers\BLISStudentsController;
use App\Http\Controllers\BSITStudentsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/', [AuthenticatedSessionController::class, 'create'])
//         ->name('welcome');




Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [MainController::class, 'dashboard'])->name('dashboard');
    //OTP
    Route::get('/verify_otp', [MainController::class, 'verify_otp'])->name('verify.otp');
    Route::post('/verify_otp', [MainController::class, 'go_verify'])->name('go.verify');
});



    // ADMIN
    Route::get('/admin/register', [AdminController::class, 'register'])->name('admin.register');
    Route::post('/admin/register', [AdminController::class, 'register_save'])->name('admin.register.save');
    Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/admin/login', [AdminController::class, 'login_proceed'])->name('admin.login.proceed');
    
Route::middleware(['auth:admin'])->group(function () {
    //Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
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








    // BSIT ROUTES
    Route::get('/main', [MainController::class, 'show'])->name('main');

    //SELECTION OF TASK
    Route::get('/students_add/{task}/{student_course}', [MainController::class, 'students_add'])->name('students_add');
    


    Route::post('/students_store/{student_course}/{task}', [MainController::class, 'store'])->name('students.store');



    Route::get('/students_edit/{id}', [MainController::class, 'edit'])->name('students.edit');
    Route::post('/students_destroy/{id}', [MainController::class, 'destroy'])->name('students.destroy');
    Route::put('/students_update/{id}', [MainController::class, 'update'])->name('students.update');

    Route::get('/reports', [MainController::class, 'show_reports'])->name('reports');







    // // BSCS ROUTES
    // Route::get('/bscs', [BSCSStudentController::class, 'bscs'])->name('bscs');
    // Route::get('/students_add_bscs', [BSCSStudentController::class, 'students_add_bscs'])->name('students_add_bscs');
    // Route::post('/students_store_bscs', [BSCSStudentController::class, 'store_bscs'])->name('students_bscs.store');
    


    // // BLIS Routes
    // Route::get('/blis', [BLISStudentsController::class, 'blis'])->name('blis');
    // Route::get('/students_add_blis', [BLISStudentsController::class, 'students_add_blis'])->name('students_add_blis');
    // Route::post('/students_store_blis', [BLISStudentsController::class, 'store_blis'])->name('students_blis.store');


    
    Route::get('/smslogs', [MyController::class, 'smslogs'])->name('smslogs');

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
