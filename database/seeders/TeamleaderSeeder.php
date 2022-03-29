<?php

namespace Database\Seeders;

use App\Models\Teamleader;
use Illuminate\Database\Seeder;

class TeamleaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teamleader = new Teamleader();
        $teamleader->type = "test";
        $teamleader->save();

    }
}
