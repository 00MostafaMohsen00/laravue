<?php

namespace App\Models;

use Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    public static $rules = [
        'name' => 'required|string|min:3|max:255',
        'email' => 'required|string|email|max:255|unique:admins,email,',
        'password' => 'string|min:6|',
        'password_confirmation' => 'required_with:password|same:password',
        'role_id' => 'required|integer|exists:roles,id|not_in:1',
    ];

    public function setPasswordAttribute($value)
    {
        if (!empty($value))
            $this->attributes['password'] = Hash::make($value);
    }
}
