<?php
namespace Seblhaire\Authbase\Traits;

use Seblhaire\Specialauth\Models\User; 

trait PolicyTrait{
    public function update(User $user, User $updateduser) {
        \Log::info($user->id . ' ' . $updateduser->id . ' ' . ($user->hasRole('administrator') ? 'admin': 'no'));
        return $user->hasRole('administrator') || $user->id === $updateduser->id;
    }

    public function display(User $user, User $updateduser) {
        return $user->id === $updateduser->id;
    }
}