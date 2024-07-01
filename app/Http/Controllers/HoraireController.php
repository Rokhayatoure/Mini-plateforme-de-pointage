<?php

namespace App\Http\Controllers;

use App\Models\Horaire;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HoraireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function enregistrerArrivee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user_id = $request->user_id;
        $date = Carbon::now()->format('Y-m-d');
        
        $heure=date('H:i:s');
// dd($heure);
        $horaire = Horaire::where('user_id', $user_id)->where('date', $date)->first();

        if ($horaire) {
            return response()->json(['message' => 'Vous avez déjà pointé votre arrivée aujourd\'hui.'], 400);
        }

        $horaire = new Horaire([
            'user_id' => $user_id,
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
            'user_id' => ['required', 'exists:users,id'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user_id = $request->user_id;
        $date = Carbon::now()->format('Y-m-d');

        $horaire = Horaire::where('user_id', $user_id)->where('date', $date)->first();

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
            'user_id' => $user_id,
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
    public function store(Request $request)
    {
        //
    }

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
