<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::get('users/list', [UserController::class, 'index'])->name('users.list');
    Route::post('users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('users/show/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::post('users/download/{id}', [UserController::class, 'downloadFile'])->name('users.download');
    Route::delete('user/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');

    Route::get('users/list-by/status', [UserController::class, 'listByStatus'])->name('users.list-by-status');
    Route::patch('users/update-by/status/{email}', [UserController::class, 'updateByStatus'])->name('users.updateStatus');

    // Soft Delete
    Route::get('users/thrased', [UserController::class, 'listThrasedData'])->name('users.onlyThrased');
    Route::patch('users/restore/{id}', [UserController::class, 'restoreData'])->name('users.restoreData');
});
