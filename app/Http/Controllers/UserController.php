<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Mostrar formulario
    public function edit(Request $request)
    {
        $user = $request->user(); // usuario logueado
        return view('users.edit', compact('user'));
    }

    // Actualizar datos
    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name'  => ['required','string','max:255'],
            'email' => ['required','email','max:255','unique:users,email,'.$user->id],
            // si solo quiere cambiar contraseña, puede dejarla vacía
            'password' => ['nullable','confirmed','min:8'],
        ]);

        $user->name  = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()
            ->route('users.edit')
            ->with('success', 'Perfil actualizado correctamente.');
    }
}
