<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\DataTables\UsersDataTable;
use Intervention\Image\ImageManagerStatic;
use App\Helpers\ImageFilter;
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
Route::get('user/{id}/edit', function($id){
    return $id;
})->name('user.edit');

Route::get('/dashboard', function (UsersDataTable $dataTable) {
    return $dataTable->render('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('image', function(){
    $img = ImageManagerStatic::make('image.jpg');
    $img ->filter(new ImageFilter(100));
    return $img->response();
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
