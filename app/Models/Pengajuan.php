<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan';
    protected $primary = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'jenis_magang',
        'bidang_tujuan',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_pengajuan',
        'penanggung_jawab_name',
        'penanggung_jawab_jabatan',
        'penanggung_jawab_email',
        'penanggung_jawab_nomor_hp',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pengajuan) {
            $pengajuan->id = Str::uuid();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function magang(): HasOne
    {
        return $this->hasOne(Magang::class, 'pengajuan_id');
    }
}
