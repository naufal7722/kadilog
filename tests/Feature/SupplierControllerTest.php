<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_suppliers_page(): void
    {
        $response = $this->get('/suppliers');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_users_can_view_suppliers_page(): void
    {
        $user = User::factory()->create();
        
        $supplier = Supplier::create([
            'nama_umkm' => 'Test UMKM',
            'alamat' => 'Test Alamat',
            'nama_pic' => 'Test PIC',
            'no_hp_pic' => '0812345678',
        ]);

        $response = $this->actingAs($user)->get('/suppliers');

        $response->assertStatus(200);
        $response->assertSee('Test UMKM');
        $response->assertSee((string) $supplier->kode_supplier);
    }

    public function test_user_can_create_a_supplier(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/suppliers', [
            'nama_umkm' => 'New UMKM',
            'alamat' => 'New Alamat',
            'nama_pic' => 'New PIC',
            'no_hp_pic' => '0898765432',
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('suppliers', [
            'nama_umkm' => 'New UMKM',
        ]);
    }

    public function test_user_can_update_a_supplier(): void
    {
        $user = User::factory()->create();

        $supplier = Supplier::create([
            'nama_umkm' => 'Old UMKM',
            'alamat' => 'Old Alamat',
            'nama_pic' => 'Old PIC',
            'no_hp_pic' => '0812345678',
        ]);

        $response = $this->actingAs($user)->put("/suppliers/{$supplier->kode_supplier}", [
            'nama_umkm' => 'Updated UMKMName',
            'alamat' => 'Updated AlamatName',
            'nama_pic' => 'Updated PICName',
            'no_hp_pic' => '0899999999',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('suppliers', [
            'kode_supplier' => $supplier->kode_supplier,
            'nama_umkm' => 'Updated UMKMName',
        ]);
    }

    public function test_user_can_delete_a_supplier(): void
    {
        $user = User::factory()->create();

        $supplier = Supplier::create([
            'nama_umkm' => 'Delete UMKM',
            'alamat' => 'Delete Alamat',
            'nama_pic' => 'Delete PIC',
            'no_hp_pic' => '0812345678',
        ]);

        $response = $this->actingAs($user)->delete("/suppliers/{$supplier->kode_supplier}");

        $response->assertRedirect();

        $this->assertDatabaseMissing('suppliers', [
            'kode_supplier' => $supplier->kode_supplier,
        ]);
    }
}
