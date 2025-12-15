<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReporteController;

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\OtController;
use App\Http\Controllers\EventoOperacionController;
use App\Http\Controllers\PuenteController;
use App\Http\Controllers\ConductorController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\InicioCargaController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\ChecklistCamionController;

use App\Http\Controllers\TarifaRutaController;
use App\Http\Controllers\VehiculoController;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('home')
        : redirect()->route('login');
});

Auth::routes();

/*
|--------------------------------------------------------------------------
| RUTAS PRIVADAS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth.redirect'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('clientes', ClienteController::class);

    Route::resource('solicituds', SolicitudController::class)->only([
    'index','create','store','show','edit','update','destroy'
    ]);
    Route::get('/solicituds/select', [SolicitudController::class, 'select'])->name('solicituds.select');
    Route::post('solicituds/{solicitud}/aprobar', [SolicitudController::class, 'aprobar'])->name('solicituds.aprobar');
    Route::post('solicituds/{solicitud}/fallida', [SolicitudController::class, 'fallida'])->name('solicituds.fallida');

    Route::resource('cotizacions', CotizacionController::class);
    Route::get('cotizacions/{cotizacion}/pdf', [CotizacionController::class, 'pdf'])->name('cotizacions.pdf');
    Route::post('cotizacions/{cotizacion}/generar-ot', [CotizacionController::class, 'generarOt'])->name('cotizacions.generarOt');

    Route::resource('ots', OtController::class);
    Route::patch('ots/{ot}/estado', [OtController::class, 'updateEstado'])->name('ots.updateEstado');
    Route::get('ots/{ot}/pdf', [OtController::class, 'pdf'])->name('ots.pdf');

    Route::resource('conductors', ConductorController::class);

    Route::middleware('auth')->group(function () {
        Route::get('/mi-perfil', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/mi-perfil', [UserController::class, 'update'])->name('users.update');
    });

    Route::prefix('operacion')->name('operacion.')->group(function () {
        Route::resource('inicio-carga', InicioCargaController::class)->only(['index','show','store','edit','update','destroy']);
        Route::resource('entrega', EntregaController::class)->only(['index','show','store','edit','update','destroy']);
        Route::resource('checklist', ChecklistCamionController::class)->only(['index','show','store','edit','update','destroy']);
    });

    Route::resource('puentes', PuenteController::class)->only(['index','create','store','show']);
    Route::resource('reportes', ReporteController::class)->only(['index']);

    // ✅ Mantengo estos nombres exactos para que exista tarifaRutas.index
    Route::resource('tarifaRutas', TarifaRutaController::class);
    Route::resource('vehiculos', VehiculoController::class);

    Route::resource('evento-operacions', EventoOperacionController::class);
});

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (SIN LOGIN)
|--------------------------------------------------------------------------
*/
Route::resource('inicio-cargas', InicioCargaController::class)->only(['create','store','show']);
Route::resource('entregas', EntregaController::class)->only(['create','store','show']);
Route::resource('checklist-camions', ChecklistCamionController::class)->only(['create','store','show']);

// ✅ Solo una, no duplicada
Route::post('/seguimiento-ot', [OtController::class, 'consultar'])
    ->name('seguimiento-ot.consultar');
