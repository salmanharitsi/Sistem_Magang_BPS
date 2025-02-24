<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'bidang_tujuan'
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
}