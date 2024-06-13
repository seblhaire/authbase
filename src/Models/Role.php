<?php

namespace Seblhaire\Authbase\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Seblhaire\Authbase\Models\User;

class Role extends Eloquent {

    public function users() {
        return $this->belongsToMany(User);
    }
}
