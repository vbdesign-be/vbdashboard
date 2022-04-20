<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type1 = new Type();
        $type1->name = "Vraag";
        $type1->save();

        $type2 = new Type();
        $type2->name = "Probleem";
        $type2->save();

        $type3 = new Type();
        $type3->name = "Incident";
        $type3->save();

        $type4 = new Type();
        $type4->name = "Bug";
        $type4->save();
    }
}
