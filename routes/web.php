<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
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
    return redirect('/students');
});
Route::get('/students',[StudentController::class,'index']);
Route::get('/students/datatable',[StudentController::class,'index'])->name('students.index');
Route::post('/students/store',[StudentController::class,'store'])->name('students.store');
Route::post('/students/destroy/{id}',[StudentController::class,'destroy'])->name('students.destroy');
Route::post('/students/edit/{id}',[StudentController::class,'edit'])->name('students.edit');
