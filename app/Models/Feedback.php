<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';
    protected $primary = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'magang_id',
        // Kelompok Aplikasi
        'aplikasi_daya_tarik',
        'aplikasi_kemudahan',
        'aplikasi_efisiensi',
        'aplikasi_keandalan',
        'aplikasi_stimulasi',
        'aplikasi_originalitas',
        // Kelompok Magang
        'magang_fasilitas',
        'magang_metode',
        'magang_materi',
        'magang_pembimbing',
        'magang_relevansi',
        'magang_kepuasan',
        // Kritik & Saran
        'testimoni',
        'kritik',
        'saran'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($feedback) {
            $feedback->id = Str::uuid();
        });
    }

    public function magang()
    {
        return $this->belongsTo(Magang::class);
    }
}
