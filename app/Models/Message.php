<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'contenue',
        'userId'
        
    ];
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
