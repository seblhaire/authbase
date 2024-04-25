<?php

namespace Seblhaire\Authbase\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Profile extends Eloquent {

    public function users() {
        return $this->belongsToMany(\Seblhaire\Authbase\Models\User);
    }
}
