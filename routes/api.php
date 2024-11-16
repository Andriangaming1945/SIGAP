<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\DiabetesController;
use App\Http\Controllers\DiabetesPredictionController;
use App\Http\Controllers\DiseaseDetailController;
use App\Http\Controllers\DiseaseHistoryController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\FoodCompositionController;
use App\Http\Controllers\HeartDiseasePredictionController;
use App\Http\Controllers\HypertensionPredictionController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\LeukemiaPredictionController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\RiskPredictionController;
use App\Http\Controllers\TbcPredictionController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes (tidak perlu token)
Route::middleware(['guest'])->group(function(){
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [ResetController::class, 'sendResetCode']);
    Route::post('/verify-reset-code', [ResetController::class, 'verifyResetCode']);
    Route::post('/reset-password', [ResetController::class, 'resetPassword']);
    Route::post('/predict-diabetes', [DiabetesPredictionController::class, 'predict']);
    Route::post('/entries', [EntryController::class, 'store']);
Route::get('/entries', [EntryController::class, 'index']);






});






// Protected routes (perlu token)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [UserProfileController::class, 'getProfile']);
    Route::get('/predictions/progress', [PredictionController::class, 'getPredictionProgress']);
    Route::get('/predictions', [PredictionController::class, 'index']);







});






