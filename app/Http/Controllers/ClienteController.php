<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ClienteRepository;
use Illuminate\Http\Request;
use Flash;

class ClienteController extends AppBaseController
{
    /** @var ClienteRepository $clienteRepository*/
    private $clienteRepository;

    public function __construct(ClienteRepository $clienteRepo)
    {
        $this->clienteRepository = $clienteRepo;
    }

    /**
     * Display a listing of the Cliente.
     */
    public function index(Request $request)
    {
        $clientes = \App\Models\Cliente::orderBy('razon_social', 'asc')->paginate(10);

        return view('clientes.index', compact('clientes'));
    }


    /**
     * Show the form for creating a new Cliente.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created Cliente in storage.
     */
    public function store(CreateClienteRequest $request)
    {
        $input = $request->all();

        $cliente = $this->clienteRepository->create($input);

        Flash::success('Clientese guardó correctamente.');

        return redirect(route('clientes.index'));
    }

    /**
     * Display the specified Cliente.
     */
    public function show($id)
    {
        $cliente = $this->clienteRepository->find($id);

        if (empty($cliente)) {
            Flash::error('Cliente not found');

            return redirect(route('clientes.index'));
        }

        return view('clientes.show')->with('cliente', $cliente);
    }

    /**
     * Show the form for editing the specified Cliente.
     */
    public function edit($id)
    {
        $cliente = $this->clienteRepository->find($id);

        if (empty($cliente)) {
            Flash::error('Cliente not found');

            return redirect(route('clientes.index'));
        }

        return view('clientes.edit')->with('cliente', $cliente);
    }

    /**
     * Update the specified Cliente in storage.
     */
    public function update($id, UpdateClienteRequest $request)
    {
        $cliente = $this->clienteRepository->find($id);

        if (empty($cliente)) {
            Flash::error('Cliente not found');

            return redirect(route('clientes.index'));
        }

        $cliente = $this->clienteRepository->update($request->all(), $id);

        Flash::success('Cliente Actualizado Correctamente.');

        return redirect(route('clientes.index'));
    }

    /**
     * Remove the specified Cliente from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $cliente = $this->clienteRepository->find($id);

        if (empty($cliente)) {
            Flash::error('Cliente not found');

            return redirect(route('clientes.index'));
        }

        $this->clienteRepository->delete($id);

        Flash::success('Cliente deleted successfully.');

        return redirect(route('clientes.index'));
    }
}
