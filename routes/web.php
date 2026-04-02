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
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

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

    /*
    |--------------------------------------------------------------------------
    | ACCESO GENERAL LOGUEADO
    |--------------------------------------------------------------------------
    */
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/mi-perfil', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/mi-perfil', [UserController::class, 'updateProfile'])->name('profile.update');

    /*
    |--------------------------------------------------------------------------
    | CHOFER + ADMINISTRADOR + DESARROLLADOR
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:chofer|administrador|desarrollador'])->group(function () {

        // OTs
        Route::resource('ots', OtController::class)->only(['index', 'show']);
        Route::get('ots/{ot}/pdf', [OtController::class, 'pdf'])->name('ots.pdf');
        Route::patch('ots/{ot}/traslado', [OtController::class, 'updateTraslado'])->name('ots.updateTraslado');
        Route::patch('ots/{ot}/costo-ext', [OtController::class, 'updateCostoExt'])->name('ots.updateCostoExt');

        // Formularios operacionales
        Route::resource('inicio-cargas', InicioCargaController::class)->only(['create','store','show']);
        Route::resource('entregas', EntregaController::class)->only(['create','store','show']);
        Route::resource('checklist-camions', ChecklistCamionController::class)->only(['create','store','show']);

        // Incidencias mínimas
        Route::resource('puentes', PuenteController::class)->only(['create','store','show']);
    });

    /*
    |--------------------------------------------------------------------------
    | ADMINISTRADOR + DESARROLLADOR
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:administrador|desarrollador'])->group(function () {

        Route::get('/home/export/excel', [HomeController::class, 'exportExcel'])
            ->name('home.export.excel');

        Route::resource('clientes', ClienteController::class);

        Route::resource('solicituds', SolicitudController::class)->only([
            'index','create','store','show','edit','update','destroy'
        ]);

        Route::get('/solicituds/select', [SolicitudController::class, 'select'])->name('solicituds.select');
        Route::post('solicituds/{solicitud}/aprobar', [SolicitudController::class, 'aprobar'])->name('solicituds.aprobar');
        Route::post('solicituds/{solicitud}/fallida', [SolicitudController::class, 'fallida'])->name('solicituds.fallida');

        Route::resource('cotizacions', CotizacionController::class);
        Route::get('cotizacions/{cotizacion}/pdf', [CotizacionController::class, 'pdf'])->name('cotizacions.pdf');
        Route::post('cotizacions/{id}/pdf/send', [CotizacionController::class, 'sendPdf'])->name('cotizacions.pdf.send');
        Route::post('cotizacions/{cotizacion}/generar-ot', [CotizacionController::class, 'generarOt'])->name('cotizacions.generarOt');

        // OTs con edición completa
        Route::resource('ots', OtController::class)->except(['index', 'show']);
        Route::patch('ots/{ot}/estado', [OtController::class, 'updateEstado'])->name('ots.updateEstado');

        Route::resource('conductors', ConductorController::class);

        Route::get('clientes/{cliente}/ejecutivos', [\App\Http\Controllers\ClienteEjecutivoController::class, 'byCliente'])
            ->name('clientes.ejecutivos');

        /*
        |--------------------------------------------------------------------------
        | GESTIÓN / HISTORIAL OPERACIONAL
        |--------------------------------------------------------------------------
        */
        Route::prefix('operacion')->name('operacion.')->group(function () {
            Route::resource('inicio-carga', InicioCargaController::class)->only([
                'index','show','edit','update','destroy'
            ]);

            Route::resource('entrega', EntregaController::class)->only([
                'index','show','edit','update','destroy'
            ]);

            Route::resource('checklist', ChecklistCamionController::class)->only([
                'index','show','edit','update','destroy'
            ]);
        });

        // Incidencias completas
        Route::resource('puentes', PuenteController::class)->only(['index','edit','update','destroy']);

        Route::resource('reportes', ReporteController::class)->only(['index']);

        Route::resource('tarifaRutas', TarifaRutaController::class);
        Route::resource('vehiculos', VehiculoController::class);

        Route::resource('evento-operacions', EventoOperacionController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | SEGURIDAD (solo desarrollador)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:desarrollador'])->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class)->only(['index', 'show']);
    });
});

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::post('/seguimiento-ot', [OtController::class, 'seguimiento'])
    ->name('seguimiento-ot.consultar');