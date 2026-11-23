<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Trainer;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::latest()->paginate(10);
        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        $trainers = Trainer::orderBy('name')->get();
        return view('admin.programs.create', compact('trainers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'trainers' => 'nullable|array',
            'trainers.*' => 'exists:trainers,id',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $program = Program::create($validated);
        if (isset($validated['trainers'])) {
            $program->trainers()->sync($validated['trainers']);
        }

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil ditambahkan.');
    }

    public function show(Program $program)
    {
        $program->load('trainers');
        return view('admin.programs.show', compact('program'));
    }

    public function edit(Program $program)
    {
        $trainers = Trainer::orderBy('name')->get();
        return view('admin.programs.edit', compact('program', 'trainers'));
    }

    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
            'is_active' => 'boolean',
            'trainers' => 'nullable|array',
            'trainers.*' => 'exists:trainers,id',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $program->update($validated);
        $program->trainers()->sync($validated['trainers'] ?? []);

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil diperbarui.');
    }

    public function destroy(Program $program)
    {
        $program->delete();
        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil dihapus.');
    }
}

