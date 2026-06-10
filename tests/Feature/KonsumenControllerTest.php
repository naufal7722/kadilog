<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Konsumen;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KonsumenControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_konsumen_page(): void
    {
        $response = $this->get('/konsumen');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_users_can_view_konsumen_page(): void
    {
        $user = User::factory()->create();
        
        $konsumen = Konsumen::create([
            'nama_konsumen' => 'Test Konsumen',
            'nama_pic_konsumen' => 'Test PIC Konsumen',
        ]);

        $response = $this->actingAs($user)->get('/konsumen');

        $response->assertStatus(200);
        $response->assertSee('Test Konsumen');
        $response->assertSee('Test PIC Konsumen');
    }

    public function test_user_can_create_a_konsumen(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/konsumen', [
            'nama_konsumen' => 'New Konsumen',
            'nama_pic_konsumen' => 'New PIC',
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('konsumens', [
            'nama_konsumen' => 'New Konsumen',
            'nama_pic_konsumen' => 'New PIC',
        ]);
    }

    public function test_user_can_update_a_konsumen(): void
    {
        $user = User::factory()->create();

        $konsumen = Konsumen::create([
            'nama_konsumen' => 'Old Konsumen',
            'nama_pic_konsumen' => 'Old PIC',
        ]);

        $response = $this->actingAs($user)->put("/konsumen/{$konsumen->kode_konsumen}", [
            'nama_konsumen' => 'Updated KonsumenName',
            'nama_pic_konsumen' => 'Updated PICName',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('konsumens', [
            'kode_konsumen' => $konsumen->kode_konsumen,
            'nama_konsumen' => 'Updated KonsumenName',
            'nama_pic_konsumen' => 'Updated PICName',
        ]);
    }

    public function test_user_can_delete_a_konsumen(): void
    {
        $user = User::factory()->create();

        $konsumen = Konsumen::create([
            'nama_konsumen' => 'Delete Konsumen',
            'nama_pic_konsumen' => 'Delete PIC',
        ]);

        $response = $this->actingAs($user)->delete("/konsumen/{$konsumen->kode_konsumen}");

        $response->assertRedirect();

        $this->assertDatabaseMissing('konsumens', [
            'kode_konsumen' => $konsumen->kode_konsumen,
        ]);
    }
}
