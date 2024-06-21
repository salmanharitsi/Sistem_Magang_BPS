<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    public $incrementing = false; 
    protected $keyType = 'string';

    protected $fillable = ['name'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    /**
     * Hubungan many-to-many dengan tabel users.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'roles_users')
                    ->withTimestamps();
    }
}
