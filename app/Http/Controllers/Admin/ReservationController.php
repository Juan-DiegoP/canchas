<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(Request $request): View
    {
        $query = Reservation::with(['field.venue', 'field.sportType', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reservations = $query->orderByDesc('date')->orderByDesc('start_time')->paginate(15)->withQueryString();

        return view('admin.reservations.index', compact('reservations'));
    }

    public function confirm(Reservation $reservation): RedirectResponse
    {
        $reservation->update(['status' => 'confirmed']);

        return back()->with('success', 'Reserva confirmada.');
    }

    public function cancel(Reservation $reservation): RedirectResponse
    {
        $reservation->update(['status' => 'cancelled']);

        return back()->with('success', 'Reserva cancelada.');
    }

    public function occupancy(Request $request): View
    {
        $fields = Field::with('venue')->orderBy('name')->get();

        $fieldId = $request->integer('field_id') ?: $fields->first()?->id;
        $field = $fields->firstWhere('id', $fieldId);

        $weekStart = $request->filled('week')
            ? Carbon::parse($request->query('week'))->startOfWeek()
            : now()->startOfWeek();

        $days = collect(range(0, 6))->map(fn ($i) => $weekStart->copy()->addDays($i));
        $hours = range(6, 22);

        $occupancyMap = [];

        if ($field) {
            $reservations = Reservation::where('field_id', $field->id)
                ->where('status', '!=', 'cancelled')
                ->whereBetween('date', [$weekStart->toDateString(), $weekStart->copy()->addDays(6)->toDateString()])
                ->get();

            foreach ($reservations as $reservation) {
                $date = $reservation->date->format('Y-m-d');
                $startHour = (int) Carbon::parse($reservation->start_time)->format('H');
                $endHour = (int) Carbon::parse($reservation->end_time)->format('H');

                for ($h = $startHour; $h < $endHour; $h++) {
                    $occupancyMap[$date][$h] = $reservation;
                }
            }
        }

        return view('admin.reservations.occupancy', compact(
            'fields', 'field', 'weekStart', 'days', 'hours', 'occupancyMap'
        ));
    }
}