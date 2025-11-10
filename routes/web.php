<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controladores base
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\ReporteController;

// Controladores principales
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\OtController;
use App\Http\Controllers\EventoOperacionController;
use App\Http\Controllers\PuenteController;

// Controladores de fases operativas
use App\Http\Controllers\InicioCargaController;
use App\Http\Controllers\EnTransitoController;
use App\Http\Controllers\EntregaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return Auth::check()
         ? redirect()->route('home')
         : redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth.redirect'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Módulos principales
    Route::resource('clientes', ClienteController::class);
    Route::resource('solicitudes', SolicitudController::class)->only(['index','create','store','show']);
    Route::resource('cotizaciones', CotizacionController::class)->only(['index','create','store','show']);
    Route::resource('ot', OtController::class)->only(['index','create','store','show','update']);

    // Operación logística
    Route::prefix('operacion')->name('operacion.')->group(function () {
        Route::resource('inicio-carga', InicioCargaController::class)->only(['index','store','show']);
        Route::resource('en-transito', EnTransitoController::class)->only(['index','store','show']);
        Route::resource('entrega', EntregaController::class)->only(['index','store','show']);
    });

    // Otros módulos
    Route::resource('puentes', PuenteController::class)->only(['index','create','store','show']);
    Route::resource('reportes', ReporteController::class)->only(['index']);
});

// Rutas autogeneradas por InfyOm (si las usas en paralelo)
Route::resource('clientes', ClienteController::class);
Route::resource('solicituds', SolicitudController::class);
Route::resource('cotizacions', CotizacionController::class);
Route::resource('ots', OtController::class);
Route::resource('evento-operacions', EventoOperacionController::class);
Route::resource('puentes', PuenteController::class);
