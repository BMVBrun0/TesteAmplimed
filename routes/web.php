<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CidadeController;
use App\Http\Controllers\Api\ClimaController;
use App\Http\Controllers\CidadeClimaController;


Route::get('/', function () {
    return view('home');
});

Route::get('/busca', function () {
    return view('busca');
});

Route::get('/comparar', function () {
    return view('comparar');
});
Route::get('/index', [CidadeClimaController::class, 'index'])->name('index');
Route::any('/getClima', [ClimaController::class, 'getClima']);
Route::any('/getCityByCep', [CidadeController::class, 'getCityByCep']);