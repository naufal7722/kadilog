<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pelabuhan;
use App\Models\Rute;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RuteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_rute_page(): void
    {
        $response = $this->get('/rute');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_users_can_view_rute_page(): void
    {
        $user = User::factory()->create();
        
        $pelabuhan = Pelabuhan::create([
            'nama_pelabuhan' => 'Pelabuhan Bintan',
            'nama_pulau' => 'Bintan',
            'nama_gudang' => 'Gudang Bintan',
        ]);

        $rute = Rute::create([
            'kode_pelabuhan' => $pelabuhan->kode_pelabuhan,
            'jarak' => 45.5,
        ]);

        $response = $this->actingAs($user)->get('/rute');

        $response->assertStatus(200);
        $response->assertSee('Pelabuhan Bintan');
        $response->assertSee('45.5 Nautical Miles');
    }

    public function test_user_can_create_a_rute(): void
    {
        $user = User::factory()->create();

        $pelabuhan = Pelabuhan::create([
            'nama_pelabuhan' => 'Pelabuhan Karimun',
            'nama_pulau' => 'Karimun',
            'nama_gudang' => 'Gudang Karimun',
        ]);

        $response = $this->actingAs($user)->post('/rute', [
            'kode_pelabuhan' => $pelabuhan->kode_pelabuhan,
            'jarak' => 50,
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('rutes', [
            'kode_pelabuhan' => $pelabuhan->kode_pelabuhan,
            'jarak' => 50,
        ]);
    }

    public function test_user_can_update_a_rute(): void
    {
        $user = User::factory()->create();

        $pelabuhan1 = Pelabuhan::create([
            'nama_pelabuhan' => 'Pelabuhan Bintan',
            'nama_pulau' => 'Bintan',
            'nama_gudang' => 'Gudang Bintan',
        ]);

        $pelabuhan2 = Pelabuhan::create([
            'nama_pelabuhan' => 'Pelabuhan Natuna',
            'nama_pulau' => 'Natuna',
            'nama_gudang' => 'Gudang Natuna',
        ]);

        $rute = Rute::create([
            'kode_pelabuhan' => $pelabuhan1->kode_pelabuhan,
            'jarak' => 45,
        ]);

        $response = $this->actingAs($user)->put("/rute/{$rute->kode_rute}", [
            'kode_pelabuhan' => $pelabuhan2->kode_pelabuhan,
            'jarak' => 300,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('rutes', [
            'kode_rute' => $rute->kode_rute,
            'kode_pelabuhan' => $pelabuhan2->kode_pelabuhan,
            'jarak' => 300,
        ]);
    }

    public function test_user_can_delete_a_rute(): void
    {
        $user = User::factory()->create();

        $pelabuhan = Pelabuhan::create([
            'nama_pelabuhan' => 'Pelabuhan Bintan',
            'nama_pulau' => 'Bintan',
            'nama_gudang' => 'Gudang Bintan',
        ]);

        $rute = Rute::create([
            'kode_pelabuhan' => $pelabuhan->kode_pelabuhan,
            'jarak' => 45,
        ]);

        $response = $this->actingAs($user)->delete("/rute/{$rute->kode_rute}");

        $response->assertRedirect();

        $this->assertDatabaseMissing('rutes', [
            'kode_rute' => $rute->kode_rute,
        ]);
    }
}
