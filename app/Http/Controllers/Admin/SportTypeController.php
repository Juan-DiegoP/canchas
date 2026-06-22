<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SportTypeRequest;
use App\Models\SportType;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SportTypeController extends Controller
{
    public function index(): View
    {
        $sportTypes = SportType::withCount('fields')->orderBy('name')->paginate(10);

        return view('admin.sport_types.index', compact('sportTypes'));
    }

    public function create(): View
    {
        return view('admin.sport_types.create');
    }

    public function store(SportTypeRequest $request): RedirectResponse
    {
        SportType::create($request->validated());

        return redirect()->route('admin.sport-types.index')->with('success', 'Deporte creado.');
    }

    public function edit(SportType $sportType): View
    {
        return view('admin.sport_types.edit', compact('sportType'));
    }

    public function update(SportTypeRequest $request, SportType $sportType): RedirectResponse
    {
        $sportType->update($request->validated());

        return redirect()->route('admin.sport-types.index')->with('success', 'Deporte actualizado.');
    }

    public function destroy(SportType $sportType): RedirectResponse
    {
        $sportType->delete();

        return back()->with('success', 'Deporte eliminado.');
    }
}