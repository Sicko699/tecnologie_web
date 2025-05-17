<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        // Mostra la homepage (index.blade.php)
        return view('index');
    }
}
