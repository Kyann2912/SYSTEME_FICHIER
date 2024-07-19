<?php
use App\Http\Controllers\FichierController;
use App\Http\Controllers\UtilisateursController;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); 

Route :: Post('/utilisateurs',[UtilisateursController::class,'store']);



Route::Post('/fichier', [FichierController::class, 'store']);

Route :: Post('/deconnexion',[UtilisateursController::class,'deconnexion']);

Route :: Post('/connexion',[UtilisateursController::class,'connexion']);


Route::Post('/fichier/liste', [FichierController::class, 'index']);

Route::get('/fichiers/{id}/download', [FichierController::class, 'download']);

Route :: Post('/login',[UtilisateursController::class, 'login']);




