<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookAPIController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EditController;
use App\Http\Controllers\ExportController;

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/addBook', function () {
    return view('addBook');
})->name('addBook');


Route::get('/google-books/search', [BookAPIController::class, 'search'])->name('google.books.search');

Route::post('/books/store', [BookController::class, 'store'])->name('books.store');

Route::get('/books/{id}', [HomeController::class, 'show'])->name('books.show');

Route::put('/books/{id}', [EditController::class, 'update'])->name('books.update');

Route::delete('/books/{id}', [EditController::class, 'destroy'])->name('books.destroy');

Route::get('/books/export/excel', [ExportController::class, 'exportBooks'])->name('books.export');
