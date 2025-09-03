<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institusi extends Model
{
    protected $table = 'institusi'; 
    protected $fillable = [
        'nama',
        'alamat',
        'status'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'institusi_id', 'id');
    }

    public function magangs()
    {
        return $this->hasManyThrough(
            Magang::class, 
            User::class,   
            'institusi_id',
            'user_id',
            'id',
            'id'
        );
    }
}
