<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_admin_routes(): void
    {
        $response = $this->get(route('admin.sport-types.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_customer_cannot_access_admin_routes(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $response = $this->actingAs($customer)->get(route('admin.sport-types.index'));

        $response->assertForbidden();
    }

    public function test_admin_can_access_admin_routes(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.sport-types.index'));

        $response->assertOk();
    }

    public function test_admin_can_create_a_sport_type(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.sport-types.store'), [
            'name' => 'Ráquetbol',
            'icon' => 'raquetbol.png',
        ]);

        $response->assertRedirect(route('admin.sport-types.index'));
        $this->assertDatabaseHas('sport_types', ['name' => 'Ráquetbol']);
    }
}