<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class TestController extends Controller
{

    public function index()
    {
        return view('testing');
    }

    public function testDefault()
    {
        return "This is a test action";
    }

    public function forceSessionExpiration()
    {
        Session::invalidate();
        Session::regenerateToken();

        return view('interventions');
    }
}


