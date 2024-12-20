<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GarderoberController;
use App\Http\Controllers\OdecaController;
use App\Http\Controllers\PlanOutfitaController;
use App\Http\Controllers\PlanOutfitaOdecaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->resource('odeca', OdecaController::class);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);


    Route::get('/garderoberi/{id}/odeca', [OdecaController::class, 'getByWardrobe']);
    Route::get('/garderoberi', [GarderoberController::class, 'index']);
    Route::get('/garderoberi/{id}', [GarderoberController::class, 'show']);
    Route::post('/garderoberi', [GarderoberController::class, 'store']);
    Route::put('/garderoberi/{id}', [GarderoberController::class, 'update']);
    Route::delete('/garderoberi/{id}', [GarderoberController::class, 'destroy']);


   


      // Dodavanje odeće u plan outfita
      Route::post('/planoutfita/{planOutfitId}/add-clothing-item', [PlanOutfitaOdecaController::class, 'addClothingItem']);
    
      // Brisanje odeće iz plana outfita
      Route::delete('/planoutfita/{planOutfitId}/remove-clothing-item/{clothingItemId}', [PlanOutfitaOdecaController::class, 'removeClothingItem']);
      
      // Prikaz svih komada odeće u planu outfita
      Route::get('/planoutfita/{planOutfitId}/clothing-items', [PlanOutfitaOdecaController::class, 'showClothingItems']);


      Route::resource('plan-outfita', PlanOutfitaController::class);

    });

 

 