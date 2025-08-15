<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensi';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'pembimbing_id',
        'status_review',
        'tanggal',
        'point_masuk',
        'point_keluar',
        'point',
        'aturan_jam_masuk',
        'aturan_jam_keluar',
        'jam_masuk',
        'jam_keluar',
        'status',
        'foto_masuk',
        'foto_keluar',
        'keterangan_izin',
        'lampiran'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function magang(): BelongsTo
    {
        return $this->belongsTo(Magang::class);
    }

    public function pembimbing(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class);
    }
}
