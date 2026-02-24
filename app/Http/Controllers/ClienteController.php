<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use App\Http\Controllers\AppBaseController;
use App\Models\ClienteEjecutivo;
use Illuminate\Support\Facades\DB;
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
        DB::transaction(function() use ($request, &$cliente) {

            $input = $request->except(['ejecutivos', 'ejecutivo_principal']);
            $cliente = $this->clienteRepository->create($input);

            $ejecutivos = $request->input('ejecutivos', []);
            $principalIndex = $request->input('ejecutivo_principal'); // índice (0,1,2...)

            foreach ($ejecutivos as $i => $ej) {
                // normaliza checkbox activo
                $activo = isset($ej['activo']) ? 1 : 0;

                ClienteEjecutivo::create([
                    'cliente_id' => $cliente->id,
                    'nombre' => $ej['nombre'] ?? '',
                    'correo' => $ej['correo'] ?? null,
                    'telefono' => $ej['telefono'] ?? null,
                    'cargo' => $ej['cargo'] ?? null,
                    'activo' => $activo,
                    'es_principal' => ((string)$principalIndex === (string)$i),
                ]);
            }
        });

        Flash::success('Cliente se guardó correctamente.');
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
        $cliente = Cliente::with('ejecutivos')->findOrFail($id);

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
        DB::transaction(function() use ($id, $request, &$cliente) {

            $cliente = $this->clienteRepository->find($id);
            $this->clienteRepository->update($request->except(['ejecutivos','ejecutivo_principal']), $id);

            $ejecutivos = $request->input('ejecutivos', []);
            $principalIndex = $request->input('ejecutivo_principal');

            $idsEnviados = collect($ejecutivos)->pluck('id')->filter()->map(fn($v)=>(int)$v)->values()->all();

            // elimina ejecutivos que fueron quitados en el form
            \App\Models\ClienteEjecutivo::where('cliente_id', $cliente->id)
                ->when(count($idsEnviados) > 0, fn($q) => $q->whereNotIn('id', $idsEnviados))
                ->when(count($idsEnviados) === 0, fn($q) => $q) // si no envías ninguno, borra todos
                ->delete();

            foreach ($ejecutivos as $i => $ej) {
                $activo = isset($ej['activo']) ? 1 : 0;

                $data = [
                    'cliente_id' => $cliente->id,
                    'nombre' => $ej['nombre'] ?? '',
                    'correo' => $ej['correo'] ?? null,
                    'telefono' => $ej['telefono'] ?? null,
                    'cargo' => $ej['cargo'] ?? null,
                    'activo' => $activo,
                    'es_principal' => ((string)$principalIndex === (string)$i),
                ];

                if (!empty($ej['id'])) {
                    // update
                    \App\Models\ClienteEjecutivo::where('cliente_id', $cliente->id)
                        ->where('id', $ej['id'])
                        ->update($data);
                } else {
                    // create
                    \App\Models\ClienteEjecutivo::create($data);
                }
            }
        });

        Flash::success('Cliente actualizado correctamente.');
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
