<?php

namespace App\Http\Controllers;

class DoctorController extends Controller
{
    public function index()
    {
        // Mostra la pagina dei dottori (doctor.blade.php)
        return view('doctor');
    }
}
