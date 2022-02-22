<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faq1 = new Faq();
        $faq1->question = "Voorbeeld vraag1";
        $faq1->answer = "Phasellus enim libero, mollis ac ex sit amet, fermentum commodo velit. Etiam eleifend, dui quis facilisis auctor, risus ex molestie elit, non molestie lorem metus nec lorem. Praesent sed massa vel sapien sodales rhoncus. Aliquam vel turpis laoreet, vestibulum felis eu, viverra ex. Nam venenatis lobortis est feugiat interdum. Nunc pretium euismod enim sit amet tincidunt. Nullam et turpis in nisi semper pellentesque. Nulla facilisi. Integer sit amet augue a dolor mattis tempus. Nulla non tincidunt urna.";
        $faq1->save();

        $faq2 = new Faq();
        $faq2->question = "Voorbeeld vraag2";
        $faq2->answer = "Phasellus enim libero, mollis ac ex sit amet, fermentum commodo velit. Etiam eleifend, dui quis facilisis auctor, risus ex molestie elit, non molestie lorem metus nec lorem. Praesent sed massa vel sapien sodales rhoncus. Aliquam vel turpis laoreet, vestibulum felis eu, viverra ex. Nam venenatis lobortis est feugiat interdum. Nunc pretium euismod enim sit amet tincidunt. Nullam et turpis in nisi semper pellentesque. Nulla facilisi. Integer sit amet augue a dolor mattis tempus. Nulla non tincidunt urna.";
        $faq2->save();

        $faq3 = new Faq();
        $faq3->question = "Voorbeeld vraag3";
        $faq3->answer = "Phasellus enim libero, mollis ac ex sit amet, fermentum commodo velit. Etiam eleifend, dui quis facilisis auctor, risus ex molestie elit, non molestie lorem metus nec lorem. Praesent sed massa vel sapien sodales rhoncus. Aliquam vel turpis laoreet, vestibulum felis eu, viverra ex. Nam venenatis lobortis est feugiat interdum. Nunc pretium euismod enim sit amet tincidunt. Nullam et turpis in nisi semper pellentesque. Nulla facilisi. Integer sit amet augue a dolor mattis tempus. Nulla non tincidunt urna.";
        $faq3->save();
    
    }
}
