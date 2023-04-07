<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = Role::where('name', 'SuperAdmin')->first();
	    $role_manager  = Role::where('name', 'Admin')->first();
	    $employee = new User();
	    $employee->name = 'Rocky';
	    $employee->email = 'rirchse@gmail.com';
	    $employee->contact = '01825322626';
	    $employee->created_by = '1';
	    $employee->password = bcrypt('testtest');
	    $employee->save();
	    $employee->roles()->attach($superadmin);
    }
}
