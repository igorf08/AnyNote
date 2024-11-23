<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\CheckIsLoggedIn;
use App\Http\Middleware\CheckIsNotLoggedIn;
use Illuminate\Support\Facades\Route;




//Auth Routes - Not Logged
Route::middleware([CheckIsNotLoggedIn::class])->group(function (){
    Route::get('/login', [AuthController::class, 'login']);
    Route::post('/loginSubmit', [AuthController::class, 'loginSubmit']);    
});


//Auth Routes - Logged
Route::middleware([CheckIsLoggedIn::class])->group(function (){
    //Create, Edit and Delete
    Route::get('/', [MainController::class, 'index'])->name('home');

    Route::get('/newNote', [MainController::class, 'newNote'])->name('new');
    Route::post('/newNoteSubmit', [MainController::class, 'newNoteSubmit'])->name('newNoteSubmit');
    
    
    Route::get('/editNote/{id}', [MainController::class, 'editNote'])->name('edit');
    Route::post('/editNoteSubmit', [MainController::class, 'editNoteSubmit'])->name('editNoteSubmit');
    
    
    Route::get('/deleteNote/{id}', [MainController::class, 'deleteNote'])->name('delete');
    Route::get('/deleteConfirm/{id}', [MainController::class, 'deleteNoteConfirm'])->name('deleteConfirm');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
