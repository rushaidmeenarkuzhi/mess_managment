<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\master\ComplaintController;
use App\Http\Controllers\master\ItemController;
use App\Http\Controllers\master\SalesController;
use App\Http\Controllers\Master\TechnicianController;
use App\Http\Controllers\master\UserController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::resource('/item', ItemController::class);
Route::resource('/user', UserController::class);
Route::resource('/report', ReportController::class);
Route::resource('/sales', SalesController::class);

Route::post('ajax/{method}', function ($method) {

		return App::call('\App\Http\Controllers\AjaxController@' . $method);
	});

Route::get('/upload_item', [ItemController::class, 'upload_item'])->name('item.upload_item');
Route::get('/download_excel', [ItemController::class, 'download_excel'])->name('item.download_excel');
Route::post('/fileUpload', [ItemController::class, 'fileUpload'])->name('item.fileUpload');
Route::get('/sales/print/{id}', [SalesController::class, 'show'])->name('sales.print');
// Route::get('/sale_print', [SalesController::class, 'printview'])->name('sale_print.print');

