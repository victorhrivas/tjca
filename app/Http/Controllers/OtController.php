<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOtRequest;
use App\Http\Requests\UpdateOtRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\OtRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Conductor;
use App\Models\Ot;
use Flash;

class OtController extends AppBaseController
{
    /** @var OtRepository $otRepository*/
    private $otRepository;

    public function __construct(OtRepository $otRepo)
    {
        $this->otRepository = $otRepo;
    }

    /**
     * Display a listing of the Ot.
     */
    public function index(Request $request)
    {
        $ots = \App\Models\Ot::with('cotizacion.solicitud.cliente')->paginate(10);
        return view('ots.index', compact('ots'));
    }


    /**
     * Show the form for creating a new Ot.
     */
    public function create()
    {
        // Trae solo los conductores activos, ordenados alfabéticamente
        $conductores = Conductor::where('activo', true)
            ->orderBy('nombre')
            ->pluck('nombre', 'nombre'); 
            // clave y valor = nombre, porque tu OT usa un string como conductor

        return view('ots.create', compact('conductores'));
    }

    /**
     * Store a newly created Ot in storage.
     */
    public function store(CreateOtRequest $request)
    {
        $input = $request->all();

        $ot = $this->otRepository->create($input);

        Flash::success('Otse guardó correctamente.');

        return redirect(route('ots.index'));
    }

    /**
     * Display the specified Ot.
     */
    public function show($id)
    {
        $ot = $this->otRepository->find($id);

        if (empty($ot)) {
            Flash::error('Ot not found');

            return redirect(route('ots.index'));
        }

        return view('ots.show')->with('ot', $ot);
    }

    public function pdf($id)
    {
        $ot = Ot::with('cotizacion')->findOrFail($id);

        $pdf = Pdf::loadView('ots.pdf', [
            'ot' => $ot,
        ])->setPaper('A4', 'portrait');

        $fileName = 'ot_' . $ot->id . '.pdf';

        return $pdf->stream($fileName);
        // o ->download($fileName) si se quiere descargar al tiro
    }

    /**
     * Show the form for editing the specified Ot.
     */
    public function edit($id)
    {
        $ot = $this->otRepository->find($id);

        if (empty($ot)) {
            Flash::error('OT no encontrada');

            return redirect(route('ots.index'));
        }

        // Conductores activos para el select
        $conductores = Conductor::where('activo', true)
            ->orderBy('nombre')
            ->pluck('nombre', 'nombre'); // clave y valor = nombre

        return view('ots.edit', compact('ot', 'conductores'));
    }

    /**
     * Update the specified Ot in storage.
     */
    public function update($id, UpdateOtRequest $request)
    {
        $ot = $this->otRepository->find($id);

        if (empty($ot)) {
            Flash::error('Ot not found');

            return redirect(route('ots.index'));
        }

        $ot = $this->otRepository->update($request->all(), $id);

        Flash::success('Ot updated successfully.');

        return redirect(route('ots.index'));
    }

    /**
     * Remove the specified Ot from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $ot = $this->otRepository->find($id);

        if (empty($ot)) {
            Flash::error('Ot not found');

            return redirect(route('ots.index'));
        }

        $this->otRepository->delete($id);

        Flash::success('Ot deleted successfully.');

        return redirect(route('ots.index'));
    }
}
