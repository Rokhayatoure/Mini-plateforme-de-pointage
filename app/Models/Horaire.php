<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horaire extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'date',
        'arriver',
        'descente',
        'heur',
        'userId'

    
        
    ];
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
