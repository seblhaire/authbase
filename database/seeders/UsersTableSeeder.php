<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Seblhaire\Specialauth\Models\Role;
use Seblhaire\Specialauth\Models\Profile;

class UsersTableSeeder extends Seeder
{
/**
 * Run the database seeds.
 *
 * @return void
 */
    public function run()
    {
        foreach( config('specialauth.roles') as $role){
            $newrole = new Role;
            $newrole->name = $role;
            $newrole->save();
        }
        foreach( config('specialauth.profiles') as $profile){
            $newprofile = new Profile;
            $newprofile->name = $profile;
            $newprofile->save();
        }
    }
}
