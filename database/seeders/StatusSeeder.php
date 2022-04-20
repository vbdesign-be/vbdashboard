<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status1 = new Status();
        $status1->name = "Open";
        $status1->save();

        $status2 = new Status();
        $status2->name = "In behandeling";
        $status2->save();

        $status3 = new Status();
        $status3->name = "Gesloten";
        $status3->save();
    }
}
