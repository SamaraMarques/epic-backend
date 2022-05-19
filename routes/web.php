<?php

use App\Http\Controllers\AnalysisController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::get('/enterprises', [EnterpriseController::class, 'index'])->middleware(['auth'])->name('enterprise:index');

Route::post('/enterprises', [EnterpriseController::class, 'create'])->middleware(['auth'])->name('enterprise:create');

Route::get('/enterprises/{enterprise_id}/sectors', [SectorController::class, 'indexByEnterprise'])->middleware(['auth'])->name('sectors:list_by_enterprise');

Route::post('/enterprises/{enterprise_id}/sectors', [SectorController::class, 'createForEnterprise'])->middleware(['auth'])->name('sectors:create_for_enterprise');

Route::patch('/enterprises/{enterprise_id}/sectors/{sector_id}', [SectorController::class, 'edit'])->middleware(['auth'])->name('sectors:edit');

Route::get('/enterprises/{enterprise_id}/analyses', [AnalysisController::class, 'indexByEnterprise'])->middleware(['auth'])->name('analyses:create_for_enterprise');

Route::post('/enterprises/{enterprise_id}/analyses', [AnalysisController::class, 'createForEnterprise'])->middleware(['auth'])->name('analyses:create_for_enterprise');

Route::post('/analyses/{analysis_id}/sectors/{sector_id}', [SectorAnswerController::class, 'create'])->middleware(['auth'])->name('answers:create_for_sectors');

Route::post('/analyses/{analysis_id}/enterprises/{enterprise_id}', [EnterpriseAnswerController::class, 'create'])->middleware(['auth'])->name('answers:create_for_sectors');

Route::get('/analyses/{analysis_id}/result', [AnalysisController::class, 'result'])->middleware(['auth'])->name('answers:create_for_sectors');
