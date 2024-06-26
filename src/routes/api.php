<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


use App\Http\Controllers\ExplorerController;
use App\Http\Controllers\ItemController;


Route::get('/explorers/{id}', [ExplorerController::class, 'showExplorers']);
Route::post('/explorers', [ExplorerController::class, 'store']);
Route::post('/explorers/{id}/location', [ExplorerController::class, 'updateLocation']);


Route::post('/explorers/{explorerId}/items', [ItemController::class, 'store']);
Route::post('/trade', [ItemController::class, 'tradeItems']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/explorers/{explorerId}/items', [ItemController::class, 'getItemsByExplorer']);
Route::post('/explorers/{explorerId}/items', [ItemController::class, 'store']);
Route::post('/trade-items', [ItemController::class, 'tradeItemsExplorers']);
