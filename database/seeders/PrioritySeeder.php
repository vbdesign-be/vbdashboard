<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $priority1 = new Priority();
        $priority1->name = "Laag";
        $priority1->save();

        $priority2 = new Priority();
        $priority2->name = "Gemiddeld";
        $priority2->save();

        $priority3 = new Priority();
        $priority3->name = "Hoog";
        $priority3->save();

        $priority4 = new Priority();
        $priority4->name = "Urgend";
        $priority4->save();

    }
}
