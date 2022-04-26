<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mailbox = new Product();
        $mailbox->name = "mailbox";
        $mailbox->price = "2.00";
        $mailbox->save();

        $transfer = new Product();
        $transfer->name = "transfer";
        $transfer->price = "2.00";
        $transfer->save();

        $domain1 = new Product();
        $domain1->name = ".be";
        $domain1->price = "1.00";
        $domain1->save();

        $domain2 = new Product();
        $domain2->name = ".nl";
        $domain2->price = "1.00";
        $domain2->save();

        $domain3 = new Product();
        $domain3->name = ".com";
        $domain3->price = "1.00";
        $domain3->save();

        $domain4 = new Product();
        $domain4->name = ".site";
        $domain4->price = "1.00";
        $domain4->save();

        $domain5 = new Product();
        $domain5->name = ".online";
        $domain5->price = "1.00";
        $domain5->save();
    }
}
