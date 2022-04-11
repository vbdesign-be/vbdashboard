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
        $user->email = "bert@vbdesign.be";
        $user->tag = 'Agent';
        $user->didLogin = 1;
        $user->isAgent = 1;
        $user->save();
    }
}
