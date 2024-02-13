<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\PermissionsController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\CompanyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TableController;
use App\Http\Controllers\Api\PDFController;
use App\Http\Controllers\Api\ExcelController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them
| will be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return ('API laravel!');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
//Route::get('/me', [AuthController::class,'me']);
//add this middleware to ensure that every request is authenticated

Route::get('/login', function(){
    // return sendError('Unauthorised', '', 401);
    return response()->json(['message' => 'Unauthorised'], 401);
})->name('login');

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/me', [AuthController::class, 'me'])->name('me');

    //Route::get('/users', [AuthController::class, 'index'])->name('index');
    Route::resource('/blog', BlogController::class)->except('create','edit');
    Route::post('/refresh/token', [AuthController::class, 'refreshToken']);

    Route::get('/companies_users', [CompanyController::class, 'getCompaniesForCurrentUser']);
});

//usuarios
Route::get('/users/{id}', [AuthController::class, 'show'])->name('show');
Route::get('/users', [AuthController::class, 'index'])->name('index');
Route::delete('/users/{id}', [AuthController::class, 'destroy'])->name('destroy');
Route::put('/users/{id}', [AuthController::class, 'update'])->name('update');

//roles permisos empresas
Route::resource('/roles', RolesController::class);
Route::resource('/permissions', PermissionsController::class);
Route::resource('/companies', CompanyController::class);
//Route::get('/companies-users', [CompanyController::class, 'getCompaniesForCurrentUser']);

//reportes example
Route::get('create-pdf-file', [PDFController::class, 'index']);
Route::get('create-excel-file', [ExcelController::class, 'index']);

//reportes table
Route::post('report/accumulated/day/table', [TableController::class, 'reportAccumulatedDayTable']);
Route::post('report/sale/table', [TableController::class, 'reportSale']);
Route::get('report/bank/table', [TableController::class, 'reportBank']);

//reportes pdf
Route::post('report/accumulated/day/pdf', [PDFController::class, 'reportAccumulatedDayPdf']);
Route::get('report/sale/pdf/day', [PDFController::class, 'reportSaleDay']);

//reportes excel
Route::post('report/excel/day', [ExcelController::class, 'reportDay']);
Route::post('report/accumulated/day/excel', [ExcelController::class, 'reportAccumulatedDayExcel']);
