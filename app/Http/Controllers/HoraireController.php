<?php

namespace App\Http\Controllers;

use App\Models\Horaire;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HoraireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function enregistrerArrivee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userId' => ['required', 'exists:users,id'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userId = $request->userId;
        $date = Carbon::now()->format('Y-m-d');
        
        $heure=date('H:i:s');
// dd($heure);
        $horaire = Horaire::where('userId', $userId)->where('date', $date)->first();

        if ($horaire) {
            return response()->json(['message' => 'Vous avez déjà pointé votre arrivée aujourd\'hui.'], 400);
        }

        $horaire = new Horaire([
            'userId' => $userId,
            'arriver' => true,
            'date' => $date,
             'heur' => $heure,
        ]);

        $horaire->save();

        return response()->json(['message' => 'Pointage d\'arrivée enregistré avec succès', 'horaire' => $horaire], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function enregistrerSortie(Request $request)
    {
      
        $validator = Validator::make($request->all(), [
            'userId' => ['required', 'exists:users,id'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $userId = $request->userId;
        $date = Carbon::now()->format('Y-m-d');

        $horaire = Horaire::where('userId', $userId)->where('date', $date)->first();

        if (!$horaire) {
            return response()->json(['message' => 'Vous devez pointer votre arrivée avant de pointer votre sortie.'], 400);
        }

        if ($horaire->descente) {
            return response()->json(['message' => 'Vous avez déjà pointé votre sortie aujourd\'hui.'], 400);
        }
        $heure=date('H:i:s');
        //   dd($heure);
        // dd('ok');

        $horaire = new Horaire([
            'userId' => $userId,
            'descente' => true,
            'date' => $date,
             'heur' => $heure,
        ]);
        $horaire->save();

        return response()->json(['message' => 'Pointage de sortie enregistré avec succès', 'horaire' => $horaire], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function listeUtilisateurPresent(Request $request)
    // {
    //      // Récupérer l'ID du rôle "admin"
    // $userPresent = DB::table('Horaire')->where('arriver', 'true')->value('id');

    // // Récupérer tous les utilisateurs pointer 
    // $users = User::where('arriver', '=',   $userPresent)->get();
    // $listUser=[];
    // foreach($users as $user){
    //     $listUser[]=[


    //     ];
    // }

    // return response()->json(compact('users'), 200);
    // }

    /**
     * Display the specified resource.
     */
    public function show(Horaire $horaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Horaire $horaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Horaire $horaire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Horaire $horaire)
    {
        //
    }
}
