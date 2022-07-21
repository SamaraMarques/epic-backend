<?php

use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\EnterpriseAnswerController;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\SectorAnswerController;
use App\Http\Controllers\SectorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';

Route::get('/me', [RegisteredUserController::class, 'me'])->middleware(['auth:sanctum'])->name('user:me');

Route::get('/enterprises', [EnterpriseController::class, 'index'])->middleware(['auth:sanctum'])->name('enterprise:index');

Route::post('/enterprises', [EnterpriseController::class, 'create'])->middleware(['auth:sanctum'])->name('enterprise:create');

Route::get('/enterprises/{enterprise_id}', [EnterpriseController::class, 'show'])->middleware(['auth:sanctum'])->name('enterprise:edit');

Route::patch('/enterprises/{enterprise_id}', [EnterpriseController::class, 'edit'])->middleware(['auth:sanctum'])->name('enterprise:edit');

Route::get('/enterprises/{enterprise_id}/sectors', [SectorController::class, 'indexByEnterprise'])->middleware(['auth:sanctum'])->name('sectors:list_by_enterprise');

Route::get('/sectors/{sector_id}', [SectorController::class, 'show'])->middleware(['auth:sanctum'])->name('sectors:show');

Route::post('/enterprises/{enterprise_id}/sectors', [SectorController::class, 'createForEnterprise'])->middleware(['auth:sanctum'])->name('sectors:create_for_enterprise');

Route::patch('/enterprises/{enterprise_id}/sectors/{sector_id}', [SectorController::class, 'edit'])->middleware(['auth:sanctum'])->name('sectors:edit');

Route::get('/enterprises/{enterprise_id}/analyses', [AnalysisController::class, 'indexByEnterprise'])->middleware(['auth:sanctum'])->name('analyses:create_for_enterprise');

Route::post('/enterprises/{enterprise_id}/analyses', [AnalysisController::class, 'createForEnterprise'])->middleware(['auth:sanctum'])->name('analyses:create_for_enterprise');

Route::post('/analyses/{analysis_id}/sectors/{sector_id}', [SectorAnswerController::class, 'create'])->middleware(['auth:sanctum'])->name('answers:create_for_sectors');

Route::post('/analyses/{analysis_id}/enterprises/{enterprise_id}', [EnterpriseAnswerController::class, 'create'])->middleware(['auth:sanctum'])->name('answers:create_for_sectors');

Route::get('/analyses/{analysis_id}/result', [AnalysisController::class, 'result'])->middleware(['auth:sanctum'])->name('analysis:result');

Route::delete('/analyses/{analysis_id}', [AnalysisController::class, 'destroy'])->middleware(['auth:sanctum'])->name('analysis:delete');