<?php

namespace Tests\Feature;

use App\Models\Field;
use App\Models\Reservation;
use App\Models\SportType;
use App\Models\User;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    protected function createField(array $attributes = []): Field
    {
        $venue = Venue::factory()->create();
        $sportType = SportType::factory()->create();

        return Field::factory()->create(array_merge([
            'venue_id' => $venue->id,
            'sport_type_id' => $sportType->id,
            'price_per_hour' => 50000,
        ], $attributes));
    }

    public function test_guest_cannot_reserve_a_field(): void
    {
        $field = $this->createField();

        $response = $this->post(route('reservations.store', $field), [
            'field_id' => $field->id,
            'date' => now()->addDay()->toDateString(),
            'start_time' => '10:00',
            'end_time' => '11:00',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseCount('reservations', 0);
    }

    public function test_customer_can_reserve_a_field_and_total_price_is_calculated(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $field = $this->createField(['price_per_hour' => 40000]);

        $response = $this->actingAs($customer)->post(route('reservations.store', $field), [
            'field_id' => $field->id,
            'date' => now()->addDay()->toDateString(),
            'start_time' => '10:00',
            'end_time' => '12:00',
        ]);

        $response->assertRedirect(route('reservations.index'));

        $this->assertDatabaseHas('reservations', [
            'field_id' => $field->id,
            'user_id' => $customer->id,
            'status' => 'pending',
            'total_price' => 80000,
        ]);
    }

    public function test_overlapping_reservations_are_rejected(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $field = $this->createField();

        Reservation::factory()->create([
            'field_id' => $field->id,
            'user_id' => $customer->id,
            'status' => 'confirmed',
            'date' => now()->addDay()->toDateString(),
            'start_time' => '10:00:00',
            'end_time' => '11:00:00',
        ]);

        $response = $this->actingAs($customer)->post(route('reservations.store', $field), [
            'field_id' => $field->id,
            'date' => now()->addDay()->toDateString(),
            'start_time' => '10:30',
            'end_time' => '11:30',
        ]);

        $response->assertSessionHasErrors('start_time');
        $this->assertDatabaseCount('reservations', 1);
    }

    public function test_customer_can_cancel_own_pending_reservation(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $field = $this->createField();

        $reservation = Reservation::factory()->create([
            'field_id' => $field->id,
            'user_id' => $customer->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($customer)
            ->patch(route('reservations.cancel', $reservation));

        $response->assertRedirect();
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'status' => 'cancelled',
        ]);
    }

    public function test_customer_cannot_cancel_a_confirmed_reservation(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $field = $this->createField();

        $reservation = Reservation::factory()->create([
            'field_id' => $field->id,
            'user_id' => $customer->id,
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($customer)
            ->patch(route('reservations.cancel', $reservation));

        $response->assertForbidden();
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'status' => 'confirmed',
        ]);
    }

    public function test_customer_cannot_cancel_another_users_reservation(): void
    {
        $owner = User::factory()->create(['role' => 'customer']);
        $otherCustomer = User::factory()->create(['role' => 'customer']);
        $field = $this->createField();

        $reservation = Reservation::factory()->create([
            'field_id' => $field->id,
            'user_id' => $owner->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($otherCustomer)
            ->patch(route('reservations.cancel', $reservation));

        $response->assertForbidden();
    }

    public function test_admin_can_cancel_any_reservation(): void
    {
        $admin = User::factory()->admin()->create();
        $customer = User::factory()->create(['role' => 'customer']);
        $field = $this->createField();

        $reservation = Reservation::factory()->create([
            'field_id' => $field->id,
            'user_id' => $customer->id,
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($admin)
            ->patch(route('reservations.cancel', $reservation));

        $response->assertRedirect();
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'status' => 'cancelled',
        ]);
    }
}