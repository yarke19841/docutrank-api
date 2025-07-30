<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
        return response()->json(['message' => 'API Laravel funcionando']);

});



Route::get('/login', function () {
    return response()->json(['error' => 'No autenticado.'], 401);
})->name('login');
