<?php

use App\User;
use Illuminate\Database\Seeder;

class OrganizerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'name'	   => 'Organizer',
        	'email'    => 'test@test.com',
        	'password' => bcrypt('123456'),
        	'role' => 2,
        ]);
    }
}
