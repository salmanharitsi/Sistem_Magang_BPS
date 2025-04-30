<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Str;

class OTP extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = 'otps';

    protected $fillable = [
        'email',  // Ganti user_id dengan email
        'otp_code',
        'verified',
        'resend_time',
        'registration_data',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'resend_time' => 'datetime',
        'registration_data' => 'array' // Cast sebagai array
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($otp){
            $otp->id = Str::uuid();

        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function canResend(): bool
    {
        if ($this->resend_count >= 3) {
            return false;
        }

        if ($this->resend_time) {
            // Check if 3 minutes have passed since last resend
            return now()->diffInMinutes($this->resend_time) >= 3;
        }

        return true;
    }

}
