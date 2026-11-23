<?php

namespace App\Http\Controllers;

use App\Models\Program;

class PublicProgramController extends Controller
{
    public function index()
    {
        $programs = Program::where('is_active', true)->with('trainers')->orderBy('name')->get();

        return view('programs.index', compact('programs'));
    }

    public function show(Program $program)
    {
        abort_unless($program->is_active, 404);
        $program->load('trainers');

        return view('programs.show', compact('program'));
    }
}
