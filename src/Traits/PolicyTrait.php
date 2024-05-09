<?php
namespace Seblhaire\Authbase\Traits;


trait PolicyTrait{
    public function update($user, $updateduser) {
        return $user->hasRole('administrator') || $user->id === $updateduser->id;
    }

    public function display($user, $updateduser) {
        return $user->id === $updateduser->id;
    }
}