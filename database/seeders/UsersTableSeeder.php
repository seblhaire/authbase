<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Seblhaire\Authbase\Models\Role;
use Seblhaire\Authbase\Models\Profile;

class UsersTableSeeder extends Seeder
{
/**
 * Run the database seeds.
 *
 * @return void
 */
    public function run()
    {
        foreach( config('authbase.roles') as $role){
            $newrole = new Role;
            $newrole->name = $role;
            $newrole->save();
        }
        foreach( config('authbase.profiles') as $profile){
            $newprofile = new Profile;
            $newprofile->name = $profile;
            $newprofile->save();
        }
    }
}
