<?php namespace Seblhaire\Authbase\Traits;

use Seblhaire\Authbase\Models\Profile;

trait ProfileUtils{
    
    public function profiles() {
        return $this->belongsToMany(Profile::class)->withPivot('jsonvals');
    }

    public function profile($val) {
        $myval = $this->profiles->where('name', $val)->first();
        if (!is_null($myval)) {
            return json_decode($myval->pivot->jsonvals);
        }
        return null;
    }
}