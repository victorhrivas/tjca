<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOtRequest;
use App\Http\Requests\UpdateOtRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\OtRepository;
use Illuminate\Http\Request;
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
        $ots = $this->otRepository->paginate(10);

        return view('ots.index')
            ->with('ots', $ots);
    }

    /**
     * Show the form for creating a new Ot.
     */
    public function create()
    {
        return view('ots.create');
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

    /**
     * Show the form for editing the specified Ot.
     */
    public function edit($id)
    {
        $ot = $this->otRepository->find($id);

        if (empty($ot)) {
            Flash::error('Ot not found');

            return redirect(route('ots.index'));
        }

        return view('ots.edit')->with('ot', $ot);
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
