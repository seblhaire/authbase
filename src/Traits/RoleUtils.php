<?php namespace Seblhaire\Authbase\Traits;

trait RoleUtils{
    
    public function roles() {
        return $this->belongsToMany(\Seblhaire\Authbase\Models\Role::class);
    }

    public function hasRole($role) {
        return $this->roles()->where('name', $role)->count() > 0;
    }
    
}