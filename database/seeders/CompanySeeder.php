<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = new Company();
        $company->name = "Verhaegen nv";
        $company->email = "test@hotmail.com";
        $company->VAT = "BE45454545";
        $company->phone = "016631465";
        $company->adress = "Beurtstraat 6";
        $company->postalcode = "3390";
        $company->city = "Tielt-Winge";
        $company->sector = "Webdevelopment";
        $company->user_id = 1;
        $company->save();
    }
}
