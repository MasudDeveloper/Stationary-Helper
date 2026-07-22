<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhotoController extends Controller
{
    public function index()
    {
        return view('photo.index');
    }

    // You can handle photo specific credit deductions or saving if necessary
    // Background removal logic will reuse the DesignAiController or happen via client-side
}
