<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ImageHandlerController;

Route::resource('questions', QuestionController::class)->shallow();
// Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
// Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
Route::get('/questions/{question}/download', [QuestionController::class, 'download'])->name('questions.download');
// Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
// Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
// Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
// Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');

Route::get('/cetakalljawapan', [QuestionController::class, 'cetakalljawapan2'])->name('questions.downloadAll');
Route::get('/cetakjawapan/{question}', [QuestionController::class, 'downloadDocx'])->name('questions.cetakjawapan');
Route::post('/upload_image', [ImageHandlerController::class, 'upload'])->name('upload.image');
Route::post('/delete_image', [ImageHandlerController::class, 'deleteImage']);
