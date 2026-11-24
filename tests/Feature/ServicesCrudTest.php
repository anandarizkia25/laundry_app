<?php

namespace Tests\Feature;

use App\Models\Services;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ServicesCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_services_management(): void
    {
        $this->get(route('services.index'))->assertRedirect(route('login'));
        $this->get(route('services.create'))->assertRedirect(route('login'));
        $this->post(route('services.store'), [])->assertRedirect(route('login'));
    }

    public function test_admin_can_view_services_list(): void
    {
        $service = Services::create([
            'service_name' => 'Cuci Kiloan Standar',
            'category' => 'Reguler',
            'price_per_unit' => 6000,
            'unit_type' => 'Kg',
            'description' => 'Layanan reguler 2 hari',
        ]);

        $response = $this->actingAs(User::factory()->admin()->create())
            ->get(route('services.index'));

        $response->assertOk()
            ->assertSee('Cuci Kiloan Standar')
            ->assertSee('Reguler')
            ->assertSee('Rp 6.000');
    }

    public function test_admin_can_view_create_service_page(): void
    {
        $response = $this->actingAs(User::factory()->admin()->create())
            ->get(route('services.create'));

        $response->assertOk()
            ->assertSee('Tambah Paket / Tarif Layanan')
            ->assertSee('Nama Service');
    }

    public function test_admin_can_create_a_new_service_with_optional_image(): void
    {
        Storage::fake('public');

        $image = UploadedFile::fake()->image('service.jpg');

        $response = $this->actingAs(User::factory()->admin()->create())
            ->post(route('services.store'), [
                'service_name' => 'Cuci Jas Super Kilat',
                'category' => 'SuperKilat',
                'price_per_unit' => 30000,
                'unit_type' => 'Pcs',
                'description' => 'Dry clean jas formal pria/wanita.',
                'image' => $image,
            ]);

        $response->assertRedirect(route('services.index'))
            ->assertSessionHas('success', 'Layanan berhasil ditambahkan.');

        $this->assertDatabaseHas('services', [
            'service_name' => 'Cuci Jas Super Kilat',
            'category' => 'SuperKilat',
            'price_per_unit' => 30000,
            'unit_type' => 'Pcs',
        ]);

        $service = Services::where('service_name', 'Cuci Jas Super Kilat')->first();
        $this->assertNotNull($service->image);
        Storage::disk('public')->assertExists($service->image);
    }

    public function test_service_creation_fails_with_invalid_data(): void
    {
        $response = $this->actingAs(User::factory()->admin()->create())
            ->post(route('services.store'), [
                'service_name' => '',
                'category' => 'InvalidCategory',
                'price_per_unit' => 0,
                'unit_type' => 'InvalidUnit',
            ]);

        $response->assertSessionHasErrors(['service_name', 'category', 'price_per_unit', 'unit_type']);
        $this->assertDatabaseCount('services', 0);
    }

    public function test_admin_can_view_edit_service_page(): void
    {
        $service = Services::create([
            'service_name' => 'Cuci Karpet',
            'category' => 'Reguler',
            'price_per_unit' => 50000,
            'unit_type' => 'Pcs',
            'description' => 'Cuci karpet ukuran sedang.',
        ]);

        $response = $this->actingAs(User::factory()->admin()->create())
            ->get(route('services.edit', $service));

        $response->assertOk()
            ->assertSee('Edit Paket / Tarif Layanan')
            ->assertSee('Cuci Karpet')
            ->assertSee('50000');
    }

    public function test_admin_can_update_service_details_and_tariff(): void
    {
        $service = Services::create([
            'service_name' => 'Cuci Kilat',
            'category' => 'Express',
            'price_per_unit' => 12000,
            'unit_type' => 'Kg',
            'description' => 'Selesai dalam 12 jam.',
        ]);

        $response = $this->actingAs(User::factory()->admin()->create())
            ->put(route('services.update', $service), [
                'service_name' => 'Cuci Kilat Super Express',
                'category' => 'Express',
                'price_per_unit' => 15000,
                'unit_type' => 'Kg',
                'description' => 'Selesai dalam 6 jam.',
            ]);

        $response->assertRedirect(route('services.index'))
            ->assertSessionHas('success', 'Layanan berhasil diperbarui.');

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'service_name' => 'Cuci Kilat Super Express',
            'price_per_unit' => 15000,
            'description' => 'Selesai dalam 6 jam.',
        ]);
    }

    public function test_admin_can_update_service_with_a_new_image(): void
    {
        Storage::fake('public');

        $service = Services::create([
            'service_name' => 'Cuci Jas',
            'category' => 'Reguler',
            'price_per_unit' => 30000,
            'unit_type' => 'Pcs',
            'image' => 'services/old_jas.jpg',
        ]);
        Storage::disk('public')->put('services/old_jas.jpg', 'old content');

        $newImage = UploadedFile::fake()->image('new_jas.jpg');

        $response = $this->actingAs(User::factory()->admin()->create())
            ->put(route('services.update', $service), [
                'service_name' => 'Cuci Jas Premium',
                'category' => 'Reguler',
                'price_per_unit' => 35000,
                'unit_type' => 'Pcs',
                'image' => $newImage,
            ]);

        $response->assertRedirect(route('services.index'))
            ->assertSessionHas('success', 'Layanan berhasil diperbarui.');

        $service->refresh();
        $this->assertNotEquals('services/old_jas.jpg', $service->image);
        Storage::disk('public')->assertMissing('services/old_jas.jpg');
        Storage::disk('public')->assertExists($service->image);
    }

    public function test_updating_service_without_new_image_preserves_existing_image(): void
    {
        Storage::fake('public');

        $service = Services::create([
            'service_name' => 'Cuci Gaun',
            'category' => 'Reguler',
            'price_per_unit' => 40000,
            'unit_type' => 'Pcs',
            'image' => 'services/gaun.jpg',
        ]);
        Storage::disk('public')->put('services/gaun.jpg', 'gaun content');

        $response = $this->actingAs(User::factory()->admin()->create())
            ->put(route('services.update', $service), [
                'service_name' => 'Cuci Gaun Pengantin',
                'category' => 'Reguler',
                'price_per_unit' => 45000,
                'unit_type' => 'Pcs',
            ]);

        $response->assertRedirect(route('services.index'))
            ->assertSessionHas('success', 'Layanan berhasil diperbarui.');

        $service->refresh();
        $this->assertEquals('services/gaun.jpg', $service->image);
        Storage::disk('public')->assertExists('services/gaun.jpg');
    }

    public function test_admin_can_delete_a_service(): void
    {
        Storage::fake('public');

        $service = Services::create([
            'service_name' => 'Layanan Lama',
            'category' => 'Reguler',
            'price_per_unit' => 4000,
            'unit_type' => 'Kg',
            'image' => 'services/old_image.jpg',
        ]);
        Storage::disk('public')->put('services/old_image.jpg', 'fake content');

        $response = $this->actingAs(User::factory()->admin()->create())
            ->delete(route('services.destroy', $service));

        $response->assertRedirect(route('services.index'))
            ->assertSessionHas('success', 'Layanan berhasil dihapus.');

        $this->assertDatabaseMissing('services', ['id' => $service->id]);
        Storage::disk('public')->assertMissing('services/old_image.jpg');
    }
}
