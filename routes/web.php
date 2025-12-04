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
use App\Http\Controllers\ConductorController;

// Controladores de fases operativas internas (panel)
use App\Http\Controllers\InicioCargaController;
use App\Http\Controllers\EnTransitoController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\ChecklistCamionController;
use App\Http\Controllers\TarifaRutaController;

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

/*
|--------------------------------------------------------------------------
| RUTAS PRIVADAS (requieren login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth.redirect'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Módulos principales (versión “nueva”)
    Route::resource('clientes', ClienteController::class);
    Route::resource('solicituds', SolicitudController::class)->only(['index','create','store','show']);
    Route::resource('cotizaciones', CotizacionController::class)->only(['index','create','store','show']);
    Route::resource('ots', OtController::class)->only(['index','create','store','show','update','destroy','edit']);
    Route::resource('conductors', ConductorController::class);

    Route::patch('ots/{ot}/estado', [OtController::class, 'updateEstado'])
        ->name('ots.updateEstado');

    // PDFs
    Route::get('cotizacions/{cotizacion}/pdf', [CotizacionController::class, 'pdf'])
        ->name('cotizacions.pdf');

    Route::get('ots/{ot}/pdf', [OtController::class, 'pdf'])
        ->name('ots.pdf');

    // Acciones sobre solicitudes / cotizaciones
    Route::get('/solicituds/select', [SolicitudController::class, 'select'])
        ->name('solicituds.select');

    Route::post('solicituds/{solicitud}/aprobar', [SolicitudController::class, 'aprobar'])
        ->name('solicituds.aprobar');

    Route::post('solicituds/{solicitud}/fallida',
        [SolicitudController::class, 'fallida']
    )->name('solicituds.fallida');

    Route::post('cotizacions/{cotizacion}/generar-ot',
        [CotizacionController::class, 'generarOt']
    )->name('cotizacions.generarOt');

    Route::prefix('operacion')->name('operacion.')->group(function () {
        Route::resource('inicio-carga', InicioCargaController::class)
            ->only(['index','show','store','edit','update','destroy']);

        Route::resource('entrega', EntregaController::class)
            ->only(['index','show','store','edit','update','destroy']);

        Route::resource('checklist', ChecklistCamionController::class)
            ->only(['index','show','store','edit','update','destroy']);
    });


    // Otros módulos internos
    Route::resource('puentes', PuenteController::class)->only(['index','create','store','show']);
    Route::resource('reportes', ReporteController::class)->only(['index']);
});

Route::resource('clientes', ClienteController::class);
Route::resource('solicituds', SolicitudController::class);
Route::resource('cotizacions', CotizacionController::class);
Route::resource('ots', OtController::class);
Route::resource('evento-operacions', EventoOperacionController::class);
Route::resource('puentes', PuenteController::class);
Route::resource('tarifaRutas', TarifaRutaController::class);
Route::resource('vehiculos', VehiculoController::class);

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS PARA FORMULARIOS (SIN LOGIN)
|--------------------------------------------------------------------------
| Usadas por los botones de "Acciones rápidas" del login.
*/
Route::resource('inicio-cargas', InicioCargaController::class)->only(['create','store','show']);
Route::resource('entregas', EntregaController::class)->only(['create','store','show']);
Route::resource('checklist-camions', ChecklistCamionController::class)->only(['create','store','show']);

Route::resource('tarifa-rutas', App\Http\Controllers\TarifaRutaController::class);
Route::resource('vehiculos', App\Http\Controllers\VehiculoController::class);