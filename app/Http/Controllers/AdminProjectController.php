<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminProjectController extends Controller
{
    function index()
    {
        return view('dashboard');
    }
}