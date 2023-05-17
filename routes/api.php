<?php

use App\Http\Controllers\NasaController;
use App\Http\Controllers\FootballDataController;
use App\Http\Controllers\AuthController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('football/competitions', [FootballDataController::class, 'getCompetitions']);
    Route::get('football/competitions/{competitionId}/teams', [FootballDataController::class, 'getTeams']);
    Route::get('football/competitions/{competitionId}/matches', [FootballDataController::class, 'getMatches']);
    Route::get('football/teams/{teamId}', [FootballDataController::class, 'getTeam']);
    Route::get('football/areas/{id}', [FootballDataController::class, 'getArea']);


    
    Route::get('nasa/asteroids', [NasaController::class, 'getAsteroids']);
    Route::get('nasa/image-of-the-day', [NasaController::class, 'getImageOfTheDay']);
    Route::get('nasa/mars-rover-photos', [NasaController::class, 'getMarsRoverPhotos']);
    Route::get('/nasa/earthimagery', [NasaController::class, 'getEarthImagery']);

});
