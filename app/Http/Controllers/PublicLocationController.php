<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class PublicLocationController extends Controller
{
    public function index()
    {
        $locations = Location::with('trainers')->orderBy('city')->orderBy('name')->get();
        return view('pages.locations', compact('locations'));
    }
}
