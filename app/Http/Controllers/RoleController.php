<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function ajouterRole(Request $request)
    {
        // Affiche les données de la requête pour débogage
      

        $validator = Validator::make($request->all(), [
            'nomRole' => ['required', 'string', 'min:4', 'regex:/^[a-zA-Z]+$/'],
        ]);
// dd($request->all());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $role = new Role([
            'nomRole' => $request->nomRole,
        ]);

        $role->save();

        return response()->json([
            'status' => true,
            'message' => "Rôle ajouté avec succès.",
            'role' => $role,
        ], 200);
    }


    public function listeRole()
    {
        $role = Role::all();

        return response()->json(compact('role'), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function  ModifierRole(Request $request, $id)
    {
        $request->validate([
            'nomRole' => 'required',
        ]);

        $role = Role::find($id);
        $role->update();
        return response()->json(['message' => 'Rôle ajouté avec succès', 'role' => $role], 200);
    }
    public function archiverRole(Request $request, $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json(['message' => 'Utilisateur non trouvé.'], 404);
        }

        // Débloquer l'utilisateur
        $role->estArchiver = true;
        $role->save();

        return response()->json([
            'status' => true,
            'message' => "cette fonction a ete archiver  avec succès.",

            'role' => $role,
        ]);
    }
    /**
     * Display the specified resource.
 


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }
}
