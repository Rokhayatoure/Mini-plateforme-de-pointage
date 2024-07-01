<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nomRole',
        'estArchiver'
        
    ];
    public function User()
    {
        return $this->hasMany(User::class);
    }
}
