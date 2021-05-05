<?php
use App\Http\Controllers\GasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Rotas GET

Route::get('/gas',[GasController::class,'index']);
Route::get('/gas/{id}',[GasController::class,'show']);


//Rotas POST

Route::post('/gas',[GasController::class,'create']);
Route::post('/gas/soma',[GasController::class,'sumQtd']);
Route::post('/gas/sub',[GasController::class,'subQtd']);

////Rotas PUT

Route::put('/gas/{id}',[GasController::class,'edit']);

////Rotas DELETE

Route::delete('/gas/{id}',[GasController::class,'destroy']);

