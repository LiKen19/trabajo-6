<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',        // 👈 obligatorio
        'email',
        'password',
        'provider',    // 👈 para Socialite
        'provider_id', // 👈 para Socialite
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
