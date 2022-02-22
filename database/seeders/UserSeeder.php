<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->firstname = "Jonathan";
        $user->lastname = "Verhaegen";
        $user->email = "jonathan_verhaegen@hotmail.com";
        $user->gsm = "0498413706";
        $user->save();
        
    }
}
