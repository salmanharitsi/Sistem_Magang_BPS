<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FungsiBagian extends Model
{
    use HasFactory;
    
    protected $table = 'fungsi_bagian';
    protected $fillable = ['title', 'description', 'jurusan'];

    public function jurusan()
    {
        return $this->hasMany(FungsiBagianJurusan::class);
    }
}