<?php

namespace Seblhaire\Authbase\Models;

use Illuminate\Auth\Authenticatable;
use Seblhaire\Authbase\Traits\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
// use Illuminate\Auth\MustVerifyEmail; this is not ncesssary since user mustget an email to create own password
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Seblhaire\Authbase\Traits\RoleUtils;

/* Replaces laravel's user that extends Illuminate\Foundation\Auth\User */

class User extends Eloquent implements
AuthenticatableContract, AuthorizableContract, CanResetPasswordContract  {

    use Authenticatable,
        Authorizable,
        CanResetPassword,
        SoftDeletes,
        Notifiable, 
        RoleUtils;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function __construct(array $attributes = []){
        parent::__construct($attributes);
        $this->with = $this->buildWith();
    }

    public function buildWith(): array{
        return  [
            'roles'
        ];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
