<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'prenom',
        'email',
        'password',
        'numeroTelephone',
        'estPresent',
        'estArchiver',
        'roleId',
        // 'horaire_id',

    ];
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function horaire()
    {
        return $this->hasmany(horaire::class);
    }
    public function message()
    {
        return $this->hasMany(Message::class);
    }




    // public static function utilisateursAbsent()
    // {
    //     return User::leftJoin('horaires', function ($join) {
    //             $join->on('users.id', '=', 'horaires.userId')
    //                 ->where('horaires.arriver', false);
    //         })
    //         ->whereNull('horaires.id') // Utilisateurs sans horaire d'arrivée vrai
    //         ->select('users.name', 'users.prenom', 'horaires.date as date_arrivee', 'horaires.heurArriver as heure_arrivee', 'horaires.created_at as date_depart', 'horaires.heurSortie as heure_depart')
    //         ->get();
    // }

    public static function utilisateursPresent($id)
    {
        return User::leftJoin('horaires', function ($join) use ($id) {
                $join->on('users.id', '=', 'horaires.userId')
                    ->where('horaires.arriver', true);
            })
            ->where('users.id', $id)
            ->select(
                'users.name', 
                'users.prenom', 
                'horaires.date as date_arrivee', 
                'horaires.heurArriver as heure_arrivee', 
                'horaires.created_at as date_depart', 
                'horaires.heurSortie as heure_depart',
                'horaires.id as id_horaire'
            )
            ->get();
    }
    public static function heurSortie($id)
    {
        return User::leftJoin('horaires', function ($join) use ($id) {
                $join->on('users.id', '=', 'horaires.userId')
                    ->where('horaires.descente', true);
            })
            ->where('users.id', $id)
            ->select(
                'users.name', 
                'users.prenom', 
                'horaires.date as date_arrivee', 
                'horaires.heurArriver as heure_arrivee', 
                'horaires.created_at as date_depart', 
                'horaires.heurSortie as heure_depart',
                'horaires.id as id_horaire'


            )
            ->get();
    }
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
