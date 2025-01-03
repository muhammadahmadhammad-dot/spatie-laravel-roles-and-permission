<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/permissions',[PermissionController::class,'index'])->name('permission.index');
    Route::get('/permissions/create',[PermissionController::class,'create'])->name('permission.create');
    Route::post('/permissions',[PermissionController::class,'store'])->name('permission.store');
    Route::get('/permissions/{id}/edit',[PermissionController::class,'edit'])->name('permission.edit');
    Route::put('/permissions/{id}',[PermissionController::class,'update'])->name('permission.update');
    Route::delete('/permissions/{id}',[PermissionController::class,'destroy'])->name('permission.destroy');

    Route::get('/roles',[RoleController::class,'index'])->name('role.index');
    Route::get('/roles/create',[RoleController::class,'create'])->name('role.create');
    Route::post('/roles',[RoleController::class,'store'])->name('role.store');
    Route::get('/roles/{id}/edit',[RoleController::class,'edit'])->name('role.edit');
    Route::put('/roles/{id}',[RoleController::class,'update'])->name('role.update');
    Route::delete('/roles/{id}',[RoleController::class,'destroy'])->name('role.destroy');

    Route::get('/blog',[BlogController::class,'index'])->name('blog.index');
    Route::get('/blog/create',[BlogController::class,'create'])->name('blog.create');
    Route::post('/blog',[BlogController::class,'store'])->name('blog.store');
    Route::get('/blog/{blog}/edit',[BlogController::class,'edit'])->name('blog.edit');
    Route::put('/blog/{blog}',[BlogController::class,'update'])->name('blog.update');
    Route::delete('/blog/{blog}',[BlogController::class,'destroy'])->name('blog.destroy');

    Route::get('/user',[UserController::class,'index'])->name('user.index');
    Route::get('/user/create',[UserController::class,'create'])->name('user.create');
    Route::post('/user',[UserController::class,'store'])->name('user.store');
    Route::get('/user/{user}/edit',[UserController::class,'edit'])->name('user.edit');
    Route::put('/user/{user}',[UserController::class,'update'])->name('user.update');
    Route::delete('/user/{user}',[UserController::class,'destroy'])->name('user.destroy');
});

require __DIR__.'/auth.php';
