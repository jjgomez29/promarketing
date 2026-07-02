<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PlayerController extends Controller
{
    public function index(): View
    {
        return view('players.index');
    }
}
