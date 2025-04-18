<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'provider',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static $rules = [
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email,',
        'password' => 'min:6|',
        'password_confirmation' => 'required_with:password|same:password',
    ];

    public function setPasswordAttribute($value)
    {
        if (!empty($value))
            $this->attributes['password'] = Hash::make($value);
    }

    public function listeings()
    {
        return $this->hasMany(Listeing::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function otps()
    {
        return $this->hasMany(Otp::class);
    }
}
