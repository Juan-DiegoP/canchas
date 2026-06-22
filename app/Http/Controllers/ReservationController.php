<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Field;
use App\Models\Reservation;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(): View
    {
        $reservations = auth()->user()
            ->reservations()
            ->with(['field.venue', 'field.sportType'])
            ->orderByDesc('date')
            ->orderByDesc('start_time')
            ->paginate(10);

        return view('reservations.index', compact('reservations'));
    }

    public function store(StoreReservationRequest $request, Field $field): RedirectResponse
    {
        $hours = (strtotime($request->end_time) - strtotime($request->start_time)) / 3600;

        Reservation::create([
            'field_id' => $field->id,
            'user_id' => auth()->id(),
            'status' => 'pending',
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'total_price' => $hours * $field->price_per_hour,
            'notes' => $request->notes,
        ]);

        return redirect()
            ->route('reservations.index')
            ->with('success', 'Reserva creada correctamente, queda pendiente de confirmación.');
    }

    public function cancel(Reservation $reservation): RedirectResponse
    {
        $this->authorize('cancel', $reservation);

        $reservation->update(['status' => 'cancelled']);

        return back()->with('success', 'Reserva cancelada.');
    }
}