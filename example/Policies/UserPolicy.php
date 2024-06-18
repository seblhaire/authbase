<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Seblhaire\Authbase\Traits\PolicyTrait;

class UserPolicy
{
    use PolicyTrait;
}
