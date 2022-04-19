<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BooksController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LibrarianController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Authentication\RegistrationController;
use App\Http\Controllers\Librarian\BooksController as LibrarianBooksController;
use App\Http\Controllers\Librarian\BooksDueController;
use App\Http\Controllers\Librarian\DashboardController as LibrarianDashboardController;
use App\Http\Controllers\Librarian\ProfileController as LibrarianProfileController;
use App\Http\Controllers\Student\BorrowbookController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\ProfileController as StudentProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(
    ['register' => false,
    'reset' => false,
    'verify' => false,]
);

Route::get('/new-user-register',[RegistrationController::class,'viewRegister']);
Route::post('/adduser',[RegistrationController::class,'adduser']);

Route::group(['middleware' => ['auth','ADMIN']],function(){
    Route::get('/admin/dashboard', [DashboardController::class,'AdminDashboard']);

    Route::get('/admin/librarian', [LibrarianController::class,'AdminLibrarian']);
    Route::post('/admin/updatelibrarian',[LibrarianController::class,'UpdateLibrarian']);

    Route::get('/admin/books', [BooksController::class,'AdminBooks']);
    Route::post('/admin/addbooks',[BooksController::class,'addBooks']);

    Route::get('/admin/students', [StudentController::class,'AdminStudent']);

    Route::get('/admin/profile', [ProfileController::class,'AdminProfile']);
    Route::post('/admin/updateprofile',[ProfileController::class,'UpdateProfile']);

    Route::get('/admin/department', [DepartmentController::class,'AdminDepartment']);
    Route::post('/admin/addDepartment',[DepartmentController::class,'addDepartment']);
});

Route::group(['middleware' => ['auth','LIBRARIAN']],function(){
    Route::get('/librarian/dashboard',[LibrarianDashboardController::class,'LibrarianDashboard']);

    Route::get('/librarian/books',[LibrarianBooksController::class,'LibrarianBooks']);
    Route::post('/librarian/books-update',[LibrarianBooksController::class,'booksUpdate']);

    Route::get('/librarian/books-due',[BooksDueController::class,'LibrarianBooksDue']);
    Route::post('/librarian/reply-request',[BooksDueController::class,'LibrarianReply']);

    Route::get('/librarian/profile',[LibrarianProfileController::class,'LibrarianProfile']);
    Route::post('/librarian/profileupdate',[LibrarianProfileController::class,'LibrarianProfileUpdate']);
});

Route::group(['middleware' => ['auth','STUDENT']],function(){
    Route::get('/student/dashboard',[StudentDashboardController::class,'StudentDashboard']);

    Route::get('/student/borrow-book',[BorrowbookController::class,'StudentBorrowBook']);
    Route::post('/student/bookRequest',[BorrowbookController::class,'bookRequest']);

    Route::get('/student/profile',[StudentProfileController::class,'StudentProfile']);
    Route::post('/student/profileupdate',[StudentProfileController::class,'UpdateProfile']);
});
