<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\SportType;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FieldController extends Controller
{
    public function index(Request $request): View
    {
        $query = Field::query()
            ->with(['venue', 'sportType'])
            ->where('active', true)
            ->whereHas('venue', fn ($q) => $q->where('active', true));

        if ($request->filled('sport_type_id')) {
            $query->where('sport_type_id', $request->sport_type_id);
        }

        if ($request->filled('city')) {
            $query->whereHas('venue', fn ($q) => $q->where('city', 'like', '%' . $request->city . '%'));
        }

        $fields = $query->paginate(9)->withQueryString();
        $sportTypes = SportType::orderBy('name')->get();
        $cities = Venue::where('active', true)->distinct()->orderBy('city')->pluck('city');

        return view('fields.index', compact('fields', 'sportTypes', 'cities'));
    }

    public function show(Field $field): View
    {
        $field->load(['venue', 'sportType']);

        $reservations = $field->reservations()
            ->where('status', '!=', 'cancelled')
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        return view('fields.show', compact('field', 'reservations'));
    }
}