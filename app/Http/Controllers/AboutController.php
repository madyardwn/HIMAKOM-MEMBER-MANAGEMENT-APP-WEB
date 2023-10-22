<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     */
    public function index()
    {
        return view('pages.about');
    }
}
