<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PeternakController;
use App\Http\Controllers\SetoranController;

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
    return view('auth.login');
});

Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'auth']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard', function () {
    return view('dashboard');
});


// halaman peternak
Route::get('/datapeternak', [PeternakController::class, 'index']);
Route::post('/peternak', [PeternakController::class, 'store'])->name('peternak.store');
Route::put('/peternak/{id}', [PeternakController::class, 'update'])->name('peternak.update');
Route::delete('/peternak/{id}', [PeternakController::class, 'destroy'])->name('peternak.destroy');


Route::get('/setoransusu', [SetoranController::class, 'index'])->name('setoran.index');
Route::post('/setoransusu', [SetoranController::class, 'store'])->name('setoran.store');
Route::get('/search-peternak', [SetoranController::class, 'search'])->name('search-peternak');




































Route::group(['middleware' => ['auth', 'role:Admin']], function() {
    





});