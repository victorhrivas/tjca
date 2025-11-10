<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCotizacionRequest;
use App\Http\Requests\UpdateCotizacionRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\CotizacionRepository;
use Illuminate\Http\Request;
use Flash;

class CotizacionController extends AppBaseController
{
    /** @var CotizacionRepository $cotizacionRepository*/
    private $cotizacionRepository;

    public function __construct(CotizacionRepository $cotizacionRepo)
    {
        $this->cotizacionRepository = $cotizacionRepo;
    }

    /**
     * Display a listing of the Cotizacion.
     */
    public function index(Request $request)
    {
        $cotizacions = $this->cotizacionRepository->paginate(10);

        return view('cotizacions.index')
            ->with('cotizacions', $cotizacions);
    }

    /**
     * Show the form for creating a new Cotizacion.
     */
    public function create()
    {
        return view('cotizacions.create');
    }

    /**
     * Store a newly created Cotizacion in storage.
     */
    public function store(CreateCotizacionRequest $request)
    {
        $input = $request->all();

        $cotizacion = $this->cotizacionRepository->create($input);

        Flash::success('Cotizacionse guardó correctamente.');

        return redirect(route('cotizacions.index'));
    }

    /**
     * Display the specified Cotizacion.
     */
    public function show($id)
    {
        $cotizacion = $this->cotizacionRepository->find($id);

        if (empty($cotizacion)) {
            Flash::error('Cotizacion not found');

            return redirect(route('cotizacions.index'));
        }

        return view('cotizacions.show')->with('cotizacion', $cotizacion);
    }

    /**
     * Show the form for editing the specified Cotizacion.
     */
    public function edit($id)
    {
        $cotizacion = $this->cotizacionRepository->find($id);

        if (empty($cotizacion)) {
            Flash::error('Cotizacion not found');

            return redirect(route('cotizacions.index'));
        }

        return view('cotizacions.edit')->with('cotizacion', $cotizacion);
    }

    /**
     * Update the specified Cotizacion in storage.
     */
    public function update($id, UpdateCotizacionRequest $request)
    {
        $cotizacion = $this->cotizacionRepository->find($id);

        if (empty($cotizacion)) {
            Flash::error('Cotizacion not found');

            return redirect(route('cotizacions.index'));
        }

        $cotizacion = $this->cotizacionRepository->update($request->all(), $id);

        Flash::success('Cotizacion updated successfully.');

        return redirect(route('cotizacions.index'));
    }

    /**
     * Remove the specified Cotizacion from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $cotizacion = $this->cotizacionRepository->find($id);

        if (empty($cotizacion)) {
            Flash::error('Cotizacion not found');

            return redirect(route('cotizacions.index'));
        }

        $this->cotizacionRepository->delete($id);

        Flash::success('Cotizacion deleted successfully.');

        return redirect(route('cotizacions.index'));
    }
}
