<?php

use App\Http\Controllers\CSVController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/quiz', [QuizPageController::class, 'show'])->name('quiz');

Route::get('/course-preview', function () {
    return redirect()->route('filament.pages.course-preview');  // Redirecționează la pagina din backend
});