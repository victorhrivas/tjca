<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTarifaRutaRequest;
use App\Http\Requests\UpdateTarifaRutaRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\TarifaRutaRepository;
use Illuminate\Http\Request;
use Flash;

class TarifaRutaController extends AppBaseController
{
    /** @var TarifaRutaRepository $tarifaRutaRepository*/
    private $tarifaRutaRepository;

    public function __construct(TarifaRutaRepository $tarifaRutaRepo)
    {
        $this->tarifaRutaRepository = $tarifaRutaRepo;
    }

    /**
     * Display a listing of the TarifaRuta.
     */
    public function index(Request $request)
    {
        $tarifaRutas = $this->tarifaRutaRepository->paginate(10);

        return view('tarifa_rutas.index')
            ->with('tarifaRutas', $tarifaRutas);
    }

    /**
     * Show the form for creating a new TarifaRuta.
     */
    public function create()
    {
        return view('tarifa_rutas.create');
    }

    /**
     * Store a newly created TarifaRuta in storage.
     */
    public function store(CreateTarifaRutaRequest $request)
    {
        $input = $request->all();

        $tarifaRuta = $this->tarifaRutaRepository->create($input);

        Flash::success('Tarifa Rutase guardó correctamente.');

        return redirect(route('tarifaRutas.index'));
    }

    /**
     * Display the specified TarifaRuta.
     */
    public function show($id)
    {
        $tarifaRuta = $this->tarifaRutaRepository->find($id);

        if (empty($tarifaRuta)) {
            Flash::error('Tarifa Ruta not found');

            return redirect(route('tarifaRutas.index'));
        }

        return view('tarifa_rutas.show')->with('tarifaRuta', $tarifaRuta);
    }

    /**
     * Show the form for editing the specified TarifaRuta.
     */
    public function edit($id)
    {
        $tarifaRuta = $this->tarifaRutaRepository->find($id);

        if (empty($tarifaRuta)) {
            Flash::error('Tarifa Ruta not found');

            return redirect(route('tarifaRutas.index'));
        }

        return view('tarifa_rutas.edit')->with('tarifaRuta', $tarifaRuta);
    }

    /**
     * Update the specified TarifaRuta in storage.
     */
    public function update($id, UpdateTarifaRutaRequest $request)
    {
        $tarifaRuta = $this->tarifaRutaRepository->find($id);

        if (empty($tarifaRuta)) {
            Flash::error('Tarifa Ruta not found');

            return redirect(route('tarifaRutas.index'));
        }

        $tarifaRuta = $this->tarifaRutaRepository->update($request->all(), $id);

        Flash::success('Tarifa Ruta updated successfully.');

        return redirect(route('tarifaRutas.index'));
    }

    /**
     * Remove the specified TarifaRuta from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $tarifaRuta = $this->tarifaRutaRepository->find($id);

        if (empty($tarifaRuta)) {
            Flash::error('Tarifa Ruta not found');

            return redirect(route('tarifaRutas.index'));
        }

        $this->tarifaRutaRepository->delete($id);

        Flash::success('Tarifa Ruta deleted successfully.');

        return redirect(route('tarifaRutas.index'));
    }
}
