<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVehiculoRequest;
use App\Http\Requests\UpdateVehiculoRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\VehiculoRepository;
use Illuminate\Http\Request;
use Flash;

class VehiculoController extends AppBaseController
{
    /** @var VehiculoRepository $vehiculoRepository*/
    private $vehiculoRepository;

    public function __construct(VehiculoRepository $vehiculoRepo)
    {
        $this->vehiculoRepository = $vehiculoRepo;
    }

    /**
     * Display a listing of the Vehiculo.
     */
    public function index(Request $request)
    {
        $vehiculos = $this->vehiculoRepository->paginate(10);

        return view('vehiculos.index')
            ->with('vehiculos', $vehiculos);
    }

    /**
     * Show the form for creating a new Vehiculo.
     */
    public function create()
    {
        return view('vehiculos.create');
    }

    /**
     * Store a newly created Vehiculo in storage.
     */
    public function store(CreateVehiculoRequest $request)
    {
        $input = $request->all();

        $vehiculo = $this->vehiculoRepository->create($input);

        Flash::success('Vehiculose guardó correctamente.');

        return redirect(route('vehiculos.index'));
    }

    /**
     * Display the specified Vehiculo.
     */
    public function show($id)
    {
        $vehiculo = $this->vehiculoRepository->find($id);

        if (empty($vehiculo)) {
            Flash::error('Vehiculo not found');

            return redirect(route('vehiculos.index'));
        }

        return view('vehiculos.show')->with('vehiculo', $vehiculo);
    }

    /**
     * Show the form for editing the specified Vehiculo.
     */
    public function edit($id)
    {
        $vehiculo = $this->vehiculoRepository->find($id);

        if (empty($vehiculo)) {
            Flash::error('Vehiculo not found');

            return redirect(route('vehiculos.index'));
        }

        return view('vehiculos.edit')->with('vehiculo', $vehiculo);
    }

    /**
     * Update the specified Vehiculo in storage.
     */
    public function update($id, UpdateVehiculoRequest $request)
    {
        $vehiculo = $this->vehiculoRepository->find($id);

        if (empty($vehiculo)) {
            Flash::error('Vehiculo not found');

            return redirect(route('vehiculos.index'));
        }

        $vehiculo = $this->vehiculoRepository->update($request->all(), $id);

        Flash::success('Vehiculo updated successfully.');

        return redirect(route('vehiculos.index'));
    }

    /**
     * Remove the specified Vehiculo from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $vehiculo = $this->vehiculoRepository->find($id);

        if (empty($vehiculo)) {
            Flash::error('Vehiculo not found');

            return redirect(route('vehiculos.index'));
        }

        $this->vehiculoRepository->delete($id);

        Flash::success('Vehiculo deleted successfully.');

        return redirect(route('vehiculos.index'));
    }
}
