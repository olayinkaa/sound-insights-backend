<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;


    const VERIFIED_USER='1';
    const UNVERIFIED_USER='0';

    const ADMIN_USER = 'admin';
    const EDITOR_USER = 'editor';
    const REGULAR_USER = 'user';

    protected $table ="users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email', 
        'password',
        'verified',
        'verification_token',
        'admin'

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 
        'remember_token',
        'verification_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);
    }


    public function isverified()
    {
        return $this->verified==User::VERIFIED_USER;
    }


    public function isAdmin()
    {
        return $this->admin==User::ADMIN_USER;
    }

    public static function generateVerificationCode()
    {
        return Str::random(10);
    }
}
