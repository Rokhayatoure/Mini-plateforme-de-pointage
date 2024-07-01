<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nom_role',
        'est_archiver'
        
    ];
    public function User()
    {
        return $this->hasMany(User::class);
    }
}