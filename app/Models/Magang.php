<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Magang extends Model
{
    use HasFactory;

    protected $table = 'magang';
    protected $primary = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'status_magang',
        'jenis_magang',
        'tanggal_mulai',
        'tanggal_selesai',
        'bidang_tujuan',
        'laporan_magang',
        'projek_magang',
        'nilai_presensi',
        'nilai_logbook',
        'nilai_lainnya',
        'nilai_magang',
        'sertifikat_magang',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($magang) {
            $magang->id = Str::uuid();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pembimbingPertama(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pembimbing_pertama', 'id');
    }

    public function pembimbingKedua(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pembimbing_kedua', 'id');
    }

    public function presensi(): HasMany
    {
        return $this->hasMany(Presensi::class);
    }

    public function logbook(): HasMany
    {
        return $this->hasMany(Logbook::class);
    }

    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id');
    }
    
    public function feedback(): HasOne
    {
        return $this->hasOne(Feedback::class);
    }
}
