<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use App\Models\Location;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index()
    {
        $trainers = Trainer::with('location')->latest()->paginate(10);
        return view('admin.trainers.index', compact('trainers'));
    }

    public function create()
    {
        $locations = Location::all();
        return view('admin.trainers.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'location_id' => 'required|exists:locations,id',
        ]);

        Trainer::create($validated);

        return redirect()->route('admin.trainers.index')->with('success', 'Trainer berhasil ditambahkan.');
    }

    public function show(Trainer $trainer)
    {
        $trainer->load('location');
        return view('admin.trainers.show', compact('trainer'));
    }

    public function edit(Trainer $trainer)
    {
        $locations = Location::all();
        return view('admin.trainers.edit', compact('trainer', 'locations'));
    }

    public function update(Request $request, Trainer $trainer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'location_id' => 'required|exists:locations,id',
        ]);

        $trainer->update($validated);

        return redirect()->route('admin.trainers.index')->with('success', 'Trainer berhasil diperbarui.');
    }

    public function destroy(Trainer $trainer)
    {
        $trainer->delete();
        return redirect()->route('admin.trainers.index')->with('success', 'Trainer berhasil dihapus.');
    }
}

