<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'google_id',
        'avatar',
        'mobile',
        'date_of_birth',
        'gender',
        'profile_image',
        'is_email_verified',
        'refresh_token',
        'email_verification_token',
        'email_verification_expiry',
        'magic_login_token',
        'magic_login_expires_at',
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

    public function add($request)
    {
        $obj = new $this;
        $obj->name = $request->name;
        $obj->email = $request->email;
        $obj->password = $request->password;
 
    }

    public function liveSession()
    {
        return $this->hasOne(LiveSession::class);
    }

}
