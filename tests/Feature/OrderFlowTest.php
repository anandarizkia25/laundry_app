<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Services;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_place_an_order_and_admin_dashboard_displays_it(): void
    {
        $service = Services::create([
            'service_name' => 'Cuci Kering',
            'category' => 'Reguler',
            'price_per_unit' => 12500,
            'unit_type' => 'Kg',
            'description' => 'Cuci dan keringkan pakaian.',
        ]);

        $this->get(route('customer.index'))
            ->assertOk()
            ->assertSee('Cuci Kering')
            ->assertSee("items[{$service->id}][service_id]", false);

        $response = $this->post(route('customer.checkout'), [
            'customer_name' => 'Budi Laundry',
            'whatsapp_number' => '081234567890',
            'items' => [
                $service->id => [
                    'service_id' => $service->id,
                    'quantity' => 2,
                ],
            ],
        ]);

        $response->assertRedirect(route('customer.index'))
            ->assertSessionHas('success', 'Pesanan berhasil dibuat.');

        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Budi Laundry',
            'whatsapp_number' => '081234567890',
            'total_price' => 25000,
            'status' => 'TransaksiMasuk',
        ]);

        $this->assertDatabaseHas('order_details', [
            'service_id' => $service->id,
            'quantity' => 2,
            'subtotal' => 25000,
        ]);

        $dashboard = $this->actingAs(User::factory()->admin()->create())
            ->get(route('dashboard'));

        $dashboard->assertOk()
            ->assertSee('Budi Laundry')
            ->assertSee('081234567890')
            ->assertSee('Cuci Kering')
            ->assertSee('TRANSAKSI MASUK')
            ->assertSee('Rp 25.000');
    }

    public function test_customer_cannot_place_an_order_without_a_selected_service(): void
    {
        $service = Services::create([
            'service_name' => 'Setrika',
            'category' => 'Reguler',
            'price_per_unit' => 5000,
            'unit_type' => 'Pcs',
        ]);

        $response = $this->post(route('customer.checkout'), [
            'customer_name' => 'Budi Laundry',
            'whatsapp_number' => '081234567890',
            'items' => [
                $service->id => [
                    'service_id' => $service->id,
                    'quantity' => 0,
                ],
            ],
        ]);

        $response->assertSessionHasErrors('items');

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('order_details', 0);
    }

    public function test_customer_page_shows_logout_for_authenticated_users(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('customer.index'))
            ->assertOk()
            ->assertSee('action="'.route('logout').'"', false)
            ->assertSee('Keluar');
    }

    public function test_customer_page_shows_login_for_guests(): void
    {
        $this->get(route('customer.index'))
            ->assertOk()
            ->assertSee('Masuk')
            ->assertDontSee('Keluar');
    }

    public function test_admin_can_update_order_status_to_a_supported_laundry_status(): void
    {
        $order = Order::create([
            'customer_name' => 'Budi Laundry',
            'whatsapp_number' => '081234567890',
            'total_price' => 25000,
            'status' => 'TransaksiMasuk',
        ]);

        $response = $this->actingAs(User::factory()->admin()->create())
            ->patch(route('admin.orders.updateStatus', $order), [
                'status' => 'Proses',
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'Proses',
        ]);
    }

    public function test_admin_cannot_update_order_status_to_an_unsupported_value(): void
    {
        $order = Order::create([
            'customer_name' => 'Budi Laundry',
            'whatsapp_number' => '081234567890',
            'total_price' => 25000,
            'status' => 'TransaksiMasuk',
        ]);

        $response = $this->actingAs(User::factory()->admin()->create())
            ->patch(route('admin.orders.updateStatus', $order), [
                'status' => 'Batal',
            ]);

        $response->assertSessionHasErrors('status');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'TransaksiMasuk',
        ]);
    }

    public function test_guest_cannot_access_the_order_dashboard(): void
    {
        $this->get(route('dashboard'))
            ->assertRedirect(route('login'));
    }
}
