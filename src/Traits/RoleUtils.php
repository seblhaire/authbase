<?php namespace Seblhaire\Authbase\Traits;

use Seblhaire\Authbase\Models\Role;


trait RoleUtils{
    
    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role) {
        return $this->roles()->where('name', $role)->count() > 0;
    }
    
}