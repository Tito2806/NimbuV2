<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\API\ActividadController;
use App\Http\Controllers\API\ActividadesClienteController;



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

/*
Route::get('/', function () {
    return redirect()->action([HomeController::class, 'index']);
});
*/
//RUTAS PARA EL CLIENTE SIN SEGURIDAD
Route::get('/', [App\Http\Controllers\ClienteController::class, 'index'])->name('inicio');
Route::get('/inicio', [App\Http\Controllers\ClienteController::class, 'index'])->name('iniciov2');
//Route::get('/actividadesNimbu', [App\Http\Controllers\ClienteController::class, 'actividades'])->name('actividades');
Route::get('/actividadesNimbu', [App\Http\Controllers\ClienteController::class, 'actividades'])->name('NimbuActividades');

//RUTAS PARA EL CLIENTE CON SEGURIDAD
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');
//Route::get('/admin/actividades', [App\Http\Controllers\API\ActividadController::class, 'index'])->name('actividadesAdmin');
//Route::get('/admin/actividades', [App\Http\Controllers\API\ActividadController::class, 'index'])->name('AdminActividades');

Auth::routes();

//Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user,index');


// Route::get('/user.get_data',[UserController::class, 'get_data'])->name('get_data');
//
//Rutas para consumir las APIS
//
Route::resource('actividadesCliente', ActividadesClienteController::class);
Route::resource('users', UsersController::class);
Route::resource('actividades', ActividadController::class);

