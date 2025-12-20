<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\MobileNumberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::view('/', 'welcome')->name('welcome');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::view('/home', 'home')->name('home');
    Route::view('/dashboard', 'home')->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
    Route::get('/employee/create', [EmployeeController::class, 'create'])->name('employee.create');
    Route::post('/employee', [EmployeeController::class, 'store'])->name('employee.store');
    Route::get('/employee/{employee}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::put('/employee/{employee}', [EmployeeController::class, 'update'])->name('employee.update');
    Route::get('/employee/{employee}', [EmployeeController::class, 'show'])->name('employee.show');

    Route::get('/student', [StudentController::class, 'index'])->name('student.index');
    Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');
    Route::post('/student', [StudentController::class, 'store'])->name('student.store');
    Route::get('/student/{student}/edit', [StudentController::class, 'edit'])->name('student.edit');
    Route::put('/student/{student}', [StudentController::class, 'update'])->name('student.update');
    Route::get('/student/{student}', [StudentController::class, 'show'])->name('student.show');

    Route::get('/installment', [InstallmentController::class, 'index'])->name('installment.index');
    Route::get('/installment/create', [InstallmentController::class, 'create'])->name('installment.create');
    Route::post('/installment', [InstallmentController::class, 'store'])->name('installment.store');

    Route::get('/mobile-numbers', [MobileNumberController::class, 'index'])->name('mobile_number.index');
    Route::get('/mobile-numbers/create', [MobileNumberController::class, 'create'])->name('mobile_number.create');
    Route::post('/mobile-numbers', [MobileNumberController::class, 'store'])->name('mobile_number.store');
});

use Illuminate\Support\Facades\Mail;

Route::get('/test-mail', function () {
    Mail::raw('Hello from Laravel via Gmail SMTP!', function ($message) {
        $message->to('kassemhajyahia@gmail.com')
            ->subject('Test Email');
    });

    return 'Email sent!';
});
