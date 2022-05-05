<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TypeaheadController extends Controller
{
    public function autocompleteSearch(Request $request)
    {
        return User::select('email')
        ->where('email', 'like', "%{$request->term}%")
        ->pluck('email');
    }
}
