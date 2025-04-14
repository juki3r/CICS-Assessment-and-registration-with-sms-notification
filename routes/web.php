<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BSCSStudentController;
use App\Http\Controllers\BLISStudentsController;
use App\Http\Controllers\BSITStudentsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware(['auth', 'verified'])->group(function () {
    // BSIT ROUTES
    Route::get('/bsit/', [BSITStudentsController::class, 'bsit'])->name('bsit');

    //SELECTION OF TASK
    Route::get('/students_add/{task}/{student_course}', [BSITStudentsController::class, 'students_add'])->name('students_add');
    


    Route::post('/students_store/{student_course}', [BSITStudentsController::class, 'store'])->name('students.store');



    Route::get('/students_edit/{id}', [BSITStudentsController::class, 'edit'])->name('students.edit');
    Route::post('/students_destroy/{id}', [BSITStudentsController::class, 'destroy'])->name('students.destroy');
    Route::put('/students_update/{id}', [BSITStudentsController::class, 'update'])->name('students.update');


    // BSCS ROUTES
    Route::get('/bscs', [BSCSStudentController::class, 'bscs'])->name('bscs');
    Route::get('/students_add_bscs', [BSCSStudentController::class, 'students_add_bscs'])->name('students_add_bscs');
    Route::post('/students_store_bscs', [BSCSStudentController::class, 'store_bscs'])->name('students_bscs.store');
    


    // BLIS Routes
    Route::get('/blis', [BLISStudentsController::class, 'blis'])->name('blis');
    Route::get('/students_add_blis', [BLISStudentsController::class, 'students_add_blis'])->name('students_add_blis');
    Route::post('/students_store_blis', [BLISStudentsController::class, 'store_blis'])->name('students_blis.store');


    
    Route::get('/smslogs', [MyController::class, 'smslogs'])->name('smslogs');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
