<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FieldRequest;
use App\Models\Field;
use App\Models\SportType;
use App\Models\Venue;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FieldController extends Controller
{
    public function index(): View
    {
        $fields = Field::with(['venue', 'sportType'])->orderBy('name')->paginate(10);

        return view('admin.fields.index', compact('fields'));
    }

    public function create(): View
    {
        $venues = Venue::orderBy('name')->get();
        $sportTypes = SportType::orderBy('name')->get();

        return view('admin.fields.create', compact('venues', 'sportTypes'));
    }

    public function store(FieldRequest $request): RedirectResponse
    {
        Field::create($request->validated());

        return redirect()->route('admin.fields.index')->with('success', 'Cancha creada.');
    }

    public function edit(Field $field): View
    {
        $venues = Venue::orderBy('name')->get();
        $sportTypes = SportType::orderBy('name')->get();

        return view('admin.fields.edit', compact('field', 'venues', 'sportTypes'));
    }

    public function update(FieldRequest $request, Field $field): RedirectResponse
    {
        $field->update($request->validated());

        return redirect()->route('admin.fields.index')->with('success', 'Cancha actualizada.');
    }

    public function destroy(Field $field): RedirectResponse
    {
        $field->delete();

        return back()->with('success', 'Cancha eliminada.');
    }
}