<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSolicitudRequest;
use App\Http\Requests\UpdateSolicitudRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\SolicitudRepository;
use Illuminate\Http\Request;
use Flash;

class SolicitudController extends AppBaseController
{
    /** @var SolicitudRepository $solicitudRepository*/
    private $solicitudRepository;

    public function __construct(SolicitudRepository $solicitudRepo)
    {
        $this->solicitudRepository = $solicitudRepo;
    }

    /**
     * Display a listing of the Solicitud.
     */
    public function index(Request $request)
    {
        $solicituds = $this->solicitudRepository->paginate(10);

        return view('solicituds.index')
            ->with('solicituds', $solicituds);
    }

    /**
     * Show the form for creating a new Solicitud.
     */
    public function create()
    {
        return view('solicituds.create');
    }

    /**
     * Store a newly created Solicitud in storage.
     */
    public function store(CreateSolicitudRequest $request)
    {
        $input = $request->all();

        $solicitud = $this->solicitudRepository->create($input);

        Flash::success('Solicitudse guardó correctamente.');

        return redirect(route('solicituds.index'));
    }

    /**
     * Display the specified Solicitud.
     */
    public function show($id)
    {
        $solicitud = $this->solicitudRepository->find($id);

        if (empty($solicitud)) {
            Flash::error('Solicitud not found');

            return redirect(route('solicituds.index'));
        }

        return view('solicituds.show')->with('solicitud', $solicitud);
    }

    /**
     * Show the form for editing the specified Solicitud.
     */
    public function edit($id)
    {
        $solicitud = $this->solicitudRepository->find($id);

        if (empty($solicitud)) {
            Flash::error('Solicitud not found');

            return redirect(route('solicituds.index'));
        }

        return view('solicituds.edit')->with('solicitud', $solicitud);
    }

    /**
     * Update the specified Solicitud in storage.
     */
    public function update($id, UpdateSolicitudRequest $request)
    {
        $solicitud = $this->solicitudRepository->find($id);

        if (empty($solicitud)) {
            Flash::error('Solicitud not found');

            return redirect(route('solicituds.index'));
        }

        $solicitud = $this->solicitudRepository->update($request->all(), $id);

        Flash::success('Solicitud updated successfully.');

        return redirect(route('solicituds.index'));
    }

    /**
     * Remove the specified Solicitud from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $solicitud = $this->solicitudRepository->find($id);

        if (empty($solicitud)) {
            Flash::error('Solicitud not found');

            return redirect(route('solicituds.index'));
        }

        $this->solicitudRepository->delete($id);

        Flash::success('Solicitud deleted successfully.');

        return redirect(route('solicituds.index'));
    }
}
