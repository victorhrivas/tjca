<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePuenteRequest;
use App\Http\Requests\UpdatePuenteRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\PuenteRepository;
use Illuminate\Http\Request;
use Flash;

class PuenteController extends AppBaseController
{
    /** @var PuenteRepository $puenteRepository*/
    private $puenteRepository;

    public function __construct(PuenteRepository $puenteRepo)
    {
        $this->puenteRepository = $puenteRepo;
    }

    /**
     * Display a listing of the Puente.
     */
    public function index(Request $request)
    {
        $puentes = $this->puenteRepository->paginate(10);

        return view('puentes.index')
            ->with('puentes', $puentes);
    }

    /**
     * Show the form for creating a new Puente.
     */
    public function create()
    {
        return view('puentes.create');
    }

    /**
     * Store a newly created Puente in storage.
     */
    public function store(CreatePuenteRequest $request)
    {
        $input = $request->all();

        $puente = $this->puenteRepository->create($input);

        Flash::success('Puentese guardó correctamente.');

        return redirect(route('puentes.index'));
    }

    /**
     * Display the specified Puente.
     */
    public function show($id)
    {
        $puente = $this->puenteRepository->find($id);

        if (empty($puente)) {
            Flash::error('Puente not found');

            return redirect(route('puentes.index'));
        }

        return view('puentes.show')->with('puente', $puente);
    }

    /**
     * Show the form for editing the specified Puente.
     */
    public function edit($id)
    {
        $puente = $this->puenteRepository->find($id);

        if (empty($puente)) {
            Flash::error('Puente not found');

            return redirect(route('puentes.index'));
        }

        return view('puentes.edit')->with('puente', $puente);
    }

    /**
     * Update the specified Puente in storage.
     */
    public function update($id, UpdatePuenteRequest $request)
    {
        $puente = $this->puenteRepository->find($id);

        if (empty($puente)) {
            Flash::error('Puente not found');

            return redirect(route('puentes.index'));
        }

        $puente = $this->puenteRepository->update($request->all(), $id);

        Flash::success('Puente updated successfully.');

        return redirect(route('puentes.index'));
    }

    /**
     * Remove the specified Puente from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $puente = $this->puenteRepository->find($id);

        if (empty($puente)) {
            Flash::error('Puente not found');

            return redirect(route('puentes.index'));
        }

        $this->puenteRepository->delete($id);

        Flash::success('Puente deleted successfully.');

        return redirect(route('puentes.index'));
    }
}
