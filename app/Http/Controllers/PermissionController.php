<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:desarrollador']);
    }

    public function index(Request $request)
    {
        $query = Permission::withCount('roles')->orderBy('name');

        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where('name', 'like', "%{$q}%");
        }

        $permissions = $query->paginate(20)->appends($request->all());

        return view('permissions.index', compact('permissions'));
    }

    public function show($id)
    {
        $permission = Permission::with('roles')->findOrFail($id);

        return view('permissions.show', compact('permission'));
    }
}