<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function support(){
        $faqs = Faq::get();

        $data['faqs'] = $faqs;
        return view('support/support', $data);
    }
}
