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
        // dd('ok');
        $validator = Validator::make($request->all(), [
            'userId' => ['required', 'exists:users,id'],
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $userId = $request->userId;
        $date = Carbon::now()->format('Y-m-d');
        $heure = Carbon::now()->format('H:i:s'); // Utiliser Carbon pour obtenir l'heure actuelle
    
        $horaire = Horaire::where('userId', $userId)->where('date', $date)->first();
    
        if ($horaire) {
            return response()->json(['message' => 'Vous avez déjà pointé votre arrivée aujourd\'hui.'], 400);
        }
    
        $horaire = new Horaire([
            'userId' => $userId,
            'arriver' => true,
            'date' => $date, // Correction ici pour utiliser le bon champ de date
            'heurArriver' => $heure, // Utiliser le champ correct pour l'heure d'arrivée
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
        $heure= Carbon::now()->format('H:i:s');
        //   dd($heure);
        // dd('ok');

        $horaire = new Horaire([
            'userId' => $userId,
            'descente' => true,
            'date' => $date,
             'heurSortie' => $heure,
        ]);
        $horaire->save();

        return response()->json(['message' => 'Pointage de sortie enregistré avec succès', 'horaire' => $horaire], 200);
    }


    public function modifierHoreireArriver(Request $request, $id)
    {
        try {
            // Valider les données de la requête
            $validatedData = $request->validate([
                'date' => 'required|date',
                // 'arriver' => 'required|boolean',
                // 'descente' => 'required|boolean',
                'heurArriver' => 'required|',
                // 'heurSortie' => 'required|',
            ]);
            // dd('ok');
            // dd($request->validate());

            // Trouver l'horaire par ID
            $horaire = Horaire::find($id);
    
            // Vérifier si l'horaire existe
            if (!$horaire) {
                return response()->json([
                    "status" => false,
                    "message" => "Horaire non trouvé"
                ], 404);
            }
    
            // Mettre à jour les champs
            $horaire->date = $validatedData['date'];
            // $horaire->arriver = $validatedData['arriver'];
            // $horaire->descente = $validatedData['descente'];
            $horaire->heurArriver = $validatedData['heurArriver'];
            // $horaire->heurSortie = $validatedData['heurSortie'];
    
            // Enregistrer les modifications
            $horaire->save();
    
            // Retourner la réponse
            return response()->json([
                "status" => true,
                "message" => "Modification réussie avec succès",
                'horaire' => $horaire
            ], 200);
        } catch (\Exception $e) {
            // Gérer les exceptions et retourner une réponse avec un statut 500
            return response()->json([
                "status" => false,
                "message" => "Erreur interne du serveur",
                "error" => $e->getMessage()
            ], 500);
        }
    }
    public function modifierHoreireSortie(Request $request, $id)
    {
        try {
            // Valider les données de la requête
            $validatedData = $request->validate([
                'date' => 'required|date',
                // 'arriver' => 'required|boolean',
                // 'descente' => 'required|boolean',
                // 'heurArriver' => 'required|',
                'heurSortie' => 'required|',
            ]);
            // dd('ok');
            // dd($request->validate());

            // Trouver l'horaire par ID
            $horaire = Horaire::find($id);
    
            // Vérifier si l'horaire existe
            if (!$horaire) {
                return response()->json([
                    "status" => false,
                    "message" => "Horaire non trouvé"
                ], 404);
            }
    
            // Mettre à jour les champs
            $horaire->date = $validatedData['date'];
            // $horaire->arriver = $validatedData['arriver'];
            // $horaire->descente = $validatedData['descente'];
            // $horaire->heurArriver = $validatedData['heurArriver'];
            $horaire->heurSortie = $validatedData['heurSortie'];
    
            // Enregistrer les modifications
            $horaire->save();
    
            // Retourner la réponse
            return response()->json([
                "status" => true,
                "message" => "Modification réussie avec succès",
                'horaire' => $horaire
            ], 200);
        } catch (\Exception $e) {
            // Gérer les exceptions et retourner une réponse avec un statut 500
            return response()->json([
                "status" => false,
                "message" => "Erreur interne du serveur",
                "error" => $e->getMessage()
            ], 500);
        }
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
    //         'id' => $users->id,
    //         'name' => $users->name,
    //         'prenom' => $users->prenom,
    //         'date' => $users->horaire->date,
    //         'heur' => $users->horaire->heur,
        

    //     ];
    //     // return response()->json(['user' =>  $listUser]);

    // }

    // return response()->json(compact('users'), 200);
    // }
    // public static function listeUtilisateurPresent(Request $request,$id)
    // {
    //     $utilisateursPresent = User::utilisaterPresent($id);
    //     return  response()->json(compact('utilisateursPresent'));
    // }

    /**
     * Display the specified resource.
     */
    public static function listeUtilisateurPresent($id)
    {
        $utilisateursPresent = User::utilisateursPresent($id);
    
        return response()->json(compact('utilisateursPresent'));
    }
    public static function listDesHorairdeSortie($id)
    {
        $utilisateursPresent = User::heurSortie($id);
    
        return response()->json(compact('utilisateursPresent'));
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
