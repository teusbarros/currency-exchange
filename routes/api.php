<?php

use Illuminate\Support\Facades\Route;

Route::get('exchange', [\teusbarros\CurrencyExchange\Http\Controllers\CurrencyController::class, 'rate']);
