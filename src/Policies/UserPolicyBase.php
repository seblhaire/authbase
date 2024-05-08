<?php

namespace Seblhaire\Authbase\Policies;

use Seblhaire\Authbase\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicyBase {

    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    public function update(User $user, User $updateduser) {
        \Log::info($user->id . ' ' . $updateduser->id . ' ' . ($user->hasRole('administrator') ? 'admin': 'no'));
        return $user->hasRole('administrator') || $user->id === $updateduser->id;
    }

    public function display(User $user, User $updateduser) {
        return $user->id === $updateduser->id;
    }
}
