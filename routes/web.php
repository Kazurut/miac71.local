<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TablesController;
use App\Http\Controllers\TestingController;

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

Route::get('/about', function () {
   return view('about');
});

Route::get('/admin', function () {
    return view('admin.main');
})->middleware('auth');
/*
Route::get ('/admin/tables', function () {
    return view('admin.tables-list');
})->middleware('auth');*/

Route::get('/admin/tables', [TablesController::class, 'table_list'])->middleware('auth');

// CRUD for tables
Route::get('/admin/tables/{table_name}', [TablesController::class, 'single_table'])->middleware('auth');
Route::get('/admin/tables/{table_name}/create', [TablesController::class, 'single_table_create'])->middleware('auth');
Route::post('/admin/tables/{table_name}/create/store', [TablesController::class, 'single_table_store'])->middleware('auth');
Route::get('/admin/tables/{table_name}/{id}/edit', [TablesController::class, 'single_table_edit'])->middleware('auth');
Route::post('/admin/tables/{table_name}/{id}/edit/store', [TablesController::class, 'single_table_store'])->middleware('auth');
Route::get('/admin/tables/{table_name}/{id}/view', [TablesController::class, 'single_table_view'])->middleware('auth');
Route::get('/admin/tables/{table_name}/{id}/delete', [TablesController::class, 'single_table_delete'])->middleware('auth');

// Testing route
Route::get('/admin/testing', [TestingController::class, 'get_all_test_list'])->middleware('auth');
Route::get('/admin/testing/graphic', [TestingController::class, 'get_all_test_list_graphic'])->middleware('auth');
Route::get('/admin/testing/graphic/{graphic_id}', [TestingController::class, 'single_graphic'])->middleware('auth');
Route::get('/admin/testing/{test_id}', [TestingController::class, 'single_test'])->name('current_test')->middleware('auth');
Route::post('/admin/testing/{test_id}/preResult/store', [TestingController::class, 'single_test_store'])->middleware('auth');


//Route::resource('/admin/tables/{table_name}', TablesControllerCRUD::class);
//Route::get('/admin/tables/{table_name}/create', [TablesController::class, 'single_table_add']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
