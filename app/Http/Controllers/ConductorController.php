<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateConductorRequest;
use App\Http\Requests\UpdateConductorRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ConductorRepository;
use Illuminate\Http\Request;
use Flash;

class ConductorController extends AppBaseController
{
    /** @var ConductorRepository $conductorRepository*/
    private $conductorRepository;

    public function __construct(ConductorRepository $conductorRepo)
    {
        $this->conductorRepository = $conductorRepo;
    }

    /**
     * Display a listing of the Conductor.
     */
    public function index(Request $request)
    {
        $conductors = $this->conductorRepository->paginate(10);

        return view('conductors.index')
            ->with('conductors', $conductors);
    }

    /**
     * Show the form for creating a new Conductor.
     */
    public function create()
    {
        return view('conductors.create');
    }

    /**
     * Store a newly created Conductor in storage.
     */
    public function store(CreateConductorRequest $request)
    {
        $input = $request->all();

        $conductor = $this->conductorRepository->create($input);

        Flash::success('Conductorse guardó correctamente.');

        return redirect(route('conductors.index'));
    }

    /**
     * Display the specified Conductor.
     */
    public function show($id)
    {
        $conductor = $this->conductorRepository->find($id);

        if (empty($conductor)) {
            Flash::error('Conductor not found');

            return redirect(route('conductors.index'));
        }

        return view('conductors.show')->with('conductor', $conductor);
    }

    /**
     * Show the form for editing the specified Conductor.
     */
    public function edit($id)
    {
        $conductor = $this->conductorRepository->find($id);

        if (empty($conductor)) {
            Flash::error('Conductor not found');

            return redirect(route('conductors.index'));
        }

        return view('conductors.edit')->with('conductor', $conductor);
    }

    /**
     * Update the specified Conductor in storage.
     */
    public function update($id, UpdateConductorRequest $request)
    {
        $conductor = $this->conductorRepository->find($id);

        if (empty($conductor)) {
            Flash::error('Conductor not found');

            return redirect(route('conductors.index'));
        }

        $conductor = $this->conductorRepository->update($request->all(), $id);

        Flash::success('Conductor Actualizado Correctamente.');

        return redirect(route('conductors.index'));
    }

    /**
     * Remove the specified Conductor from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $conductor = $this->conductorRepository->find($id);

        if (empty($conductor)) {
            Flash::error('Conductor not found');

            return redirect(route('conductors.index'));
        }

        $this->conductorRepository->delete($id);

        Flash::success('Conductor deleted successfully.');

        return redirect(route('conductors.index'));
    }
}
