<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;

class AboutController extends Controller
{
    public function index()
    {
        return view('pages.about');
    }
}
