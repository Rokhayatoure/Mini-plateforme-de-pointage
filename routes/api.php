<?php

use App\Http\Controllers\HoraireController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/AjoutRole',[RoleController::class,'AjoutRole']);
Route::get('/listeRole',[RoleController::class,'listeRole']);
Route::put('/ModifierRole/{id}',[RoleController::class,'ModifierRole']);
Route::put('/ArchiverRole/{id}',[RoleController::class,'archiverRole']);
Route::put('/ArchiverUtilisateur/{id}',[UserController::class,'ArchiverUtilisateur']);
Route::get('/ListeUtilisateurArchiver',[UserController::class,'ListeUtilisateurArchiver']);
Route::post('/inscription',[UserController::class,'inscription']);
Route::post('/connexion',[UserController::class,'connexion']);
Route::post('/deconnexion',[UserController::class,'deconnexion']);
Route::get('/listeUtilisateur',[UserController::class,'listeUtilisateur']);
Route::get('/listeUtilisateurPresent',[UserController::class,'listeUtilisateurPresent']);
Route::post('/enregistrerArrivee',[HoraireController::class,'enregistrerArrivee']);
Route::post('/enregistrerSortie',[HoraireController::class,'enregistrerSortie']);
Route::post('/listeUtilisateurPresent',[HoraireController::class,'listeUtilisateurPresent']);
Route::post('/envoyermessane',[MessageController::class,'Message']);
Route::get('/listMessane/{id}',[MessageController::class,'ListMessage']);
// Route::groupe([
//     'Middleware'=> ["auth:api"]
// ],function()[
// ]);