<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    
    public function inscription(Request $request, Role $role) {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:4', 'regex:/^[a-zA-Z]+$/'],
            'prenom' => ['required', 'string', 'min:4', 'regex:/^[a-zA-Z]+$/'],
            'email' => ['required', 'email', 'unique:users,email'],
            'numeroTelephone' => ['required', 'string', 'regex:/^(\+221|221)?[76|77|78|70|33]\d{8}$/'],
            'roleId' => ['required','integer',],
            'horaireId' => ['required','integer',],
            'password' => ['required', 'string', 'min:8'],

        ]); 

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        
        $user = new User([
            'name' => $request->name,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
             'numeroTelephone' => $request->numeroTelephone,
             'roleId' => $request->roleId ,
            'horaireId' => $request->horaireId
          
        ]);
    
        // Gérer l'upload de l'image
        
        $user->save();
    
        return response()->json([
            "status" => true,
            "message" => "utilisateur inscrit avec succes ",
            'user'=>$user
        ],200);
    }
    public function connexion(Request $request)
    {
        try {
        // Validation des données d'entrée
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Authentification de l'utilisateur
        $credentials = $request->only('email', 'password');
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                "status" => false,
                "message" => "Identifiants invalides",
            ], 401);
        }

        // Récupération de l'utilisateur
        $user = Auth::user();

        // Vérification si l'utilisateur est bloqué
        // if ($user && $user->estAloquer) {
        //     return response()->json([
        //         "status" => false,
        //         "message" => "Votre compte est bloqué. Veuillez contacter l'administrateur.",
        //     ], 403);
        // }

        // Génération du token JWT
        return response()->json([
            "status" => true,
            "message" => "Utilisateur connecté avec succès",
            "token" => $token,
            'user' => $user
        ]);

    } catch (\Exception $e) {
        return response()->json([
            "status" => false,
            "message" => "Une erreur s'est produite lors de la connexion.",
            "error" => $e->getMessage()
        ], 500);
    }
    }

    public function deconnexion(Request $request)
    {
        Auth::logout();
        return response()->json([
            "status" => true,
            "message" => "utilisateur déconnecté avec succès"
        ],200);
    }
    

    public function listeUtilisateur()
{

    $ListUser=[] ;
    // Récupérer l'ID du rôle "admin"
    $adminRoleId = DB::table('roles')->where('nomRole', 'admin')->value('id');
    // $Rolenom = DB::table('roles')->value('nomRole');
       
    // Récupérer tous les utilisateurs sauf l'admin
    $users = User::where('roleId', '!=', $adminRoleId)->get();
     foreach($users as $user){
        $ListUser[] = [
            'id' => $user->id,
            'name' => $user->name,
            'prenom' => $user->prenom,
           
            'nomRole' => $user->role->nomRole,
            'email' => $user->email,
        ];

     }

    return response()->json(compact('ListUser',), 200);
}

public function ArchiverUtilisateur(Request $request ,$id ){
   
{
    $user = User::find($id);

 // Débloquer l'utilisateur
   $user->estArchiver= true;
   $user->save();

    return response()->json([
        'status' => true,
        'message' => "cette utilisateur  a ete archiver  avec succès.",
        
        'user' =>$user,
    ]);
}
}

public function ListeUtilisateurArchiver(Request $request )
{
    $user =User::where('estArchiver', true)->get();
    // $annoncesPubliees = Annonce::where('is_published', true)->get();

    // dd($user);

    return response()->json(compact('user'), 200);

}


// public function pointage(Request $request){

// }

}
