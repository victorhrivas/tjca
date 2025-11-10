<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEventoOperacionRequest;
use App\Http\Requests\UpdateEventoOperacionRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\EventoOperacionRepository;
use Illuminate\Http\Request;
use Flash;

class EventoOperacionController extends AppBaseController
{
    /** @var EventoOperacionRepository $eventoOperacionRepository*/
    private $eventoOperacionRepository;

    public function __construct(EventoOperacionRepository $eventoOperacionRepo)
    {
        $this->eventoOperacionRepository = $eventoOperacionRepo;
    }

    /**
     * Display a listing of the EventoOperacion.
     */
    public function index(Request $request)
    {
        $eventoOperacions = $this->eventoOperacionRepository->paginate(10);

        return view('evento_operacions.index')
            ->with('eventoOperacions', $eventoOperacions);
    }

    /**
     * Show the form for creating a new EventoOperacion.
     */
    public function create()
    {
        return view('evento_operacions.create');
    }

    /**
     * Store a newly created EventoOperacion in storage.
     */
    public function store(CreateEventoOperacionRequest $request)
    {
        $input = $request->all();

        $eventoOperacion = $this->eventoOperacionRepository->create($input);

        Flash::success('Evento Operacionse guardó correctamente.');

        return redirect(route('eventoOperacions.index'));
    }

    /**
     * Display the specified EventoOperacion.
     */
    public function show($id)
    {
        $eventoOperacion = $this->eventoOperacionRepository->find($id);

        if (empty($eventoOperacion)) {
            Flash::error('Evento Operacion not found');

            return redirect(route('eventoOperacions.index'));
        }

        return view('evento_operacions.show')->with('eventoOperacion', $eventoOperacion);
    }

    /**
     * Show the form for editing the specified EventoOperacion.
     */
    public function edit($id)
    {
        $eventoOperacion = $this->eventoOperacionRepository->find($id);

        if (empty($eventoOperacion)) {
            Flash::error('Evento Operacion not found');

            return redirect(route('eventoOperacions.index'));
        }

        return view('evento_operacions.edit')->with('eventoOperacion', $eventoOperacion);
    }

    /**
     * Update the specified EventoOperacion in storage.
     */
    public function update($id, UpdateEventoOperacionRequest $request)
    {
        $eventoOperacion = $this->eventoOperacionRepository->find($id);

        if (empty($eventoOperacion)) {
            Flash::error('Evento Operacion not found');

            return redirect(route('eventoOperacions.index'));
        }

        $eventoOperacion = $this->eventoOperacionRepository->update($request->all(), $id);

        Flash::success('Evento Operacion updated successfully.');

        return redirect(route('eventoOperacions.index'));
    }

    /**
     * Remove the specified EventoOperacion from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $eventoOperacion = $this->eventoOperacionRepository->find($id);

        if (empty($eventoOperacion)) {
            Flash::error('Evento Operacion not found');

            return redirect(route('eventoOperacions.index'));
        }

        $this->eventoOperacionRepository->delete($id);

        Flash::success('Evento Operacion deleted successfully.');

        return redirect(route('eventoOperacions.index'));
    }
}
