<?php
use App\Http\Controllers\AsmaulController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// route untuk proses login
Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');
Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');


// route data user akan di tampilkan apabila sudah login
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// route untuk proses logout
Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');

// Route Untuk menampilkan data Asmaul Husna
Route::get('/asmaulHusna',[AsmaulController::class, 'index']);
Route::get('/asmaulHusna/{id}',[AsmaulController::class, 'detailAsmaul']);


//
Route::middleware(['auth:api'])->group(function(){
Route::post('/asmaulHusna',[AsmaulController::class, 'store']);
Route::put('/asmaulHusna/{id}',[AsmaulController::class, 'update']);
Route::delete('/AsmaulHusna/{id}',[AsmaulController::class, 'destroy']);
});

