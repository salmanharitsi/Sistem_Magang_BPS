<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FungsiBagianJurusan extends Model
{
    use HasFactory;

    protected $table = 'fungsi_bagian_jurusan';
    protected $fillable = ['fungsi_bagian_id', 'jurusan'];

    public function fungsiBagian()
    {
        return $this->belongsTo(FungsiBagian::class);
    }
}