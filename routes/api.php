<?php

use App\Http\Controllers\StockController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/stock-quote', [StockController::class, 'getStockQuote']);
Route::post('/search-symbol', [StockController::class, 'searchSymbol']);
Route::post('/stock/index', [StockController::class, 'index']);
