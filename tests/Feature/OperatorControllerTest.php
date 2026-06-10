<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Operator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OperatorControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_operators_page(): void
    {
        $response = $this->get('/operators');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_users_can_view_operators_page(): void
    {
        $user = User::factory()->create();
        
        $pelabuhan = \App\Models\Pelabuhan::create([
            'nama_pelabuhan' => 'Test Port',
            'nama_pulau' => 'Batam',
            'nama_gudang' => 'Gudang A'
        ]);

        $operator = Operator::create([
            'nama_operator' => 'Test Operator',
            'no_hp' => '0812345678',
            'kode_pelabuhan' => $pelabuhan->kode_pelabuhan,
        ]);

        $response = $this->actingAs($user)->get('/operators');

        $response->assertStatus(200);
        $response->assertSee('Test Operator');
        $response->assertSee('0812345678');
    }

    public function test_user_can_create_a_operator(): void
    {
        $user = User::factory()->create();

        $pelabuhan = \App\Models\Pelabuhan::create([
            'nama_pelabuhan' => 'Test Port',
            'nama_pulau' => 'Batam',
            'nama_gudang' => 'Gudang A'
        ]);

        $response = $this->actingAs($user)->post('/operators', [
            'nama_operator' => 'New Operator',
            'no_hp' => '0898765432',
            'kode_pelabuhan' => $pelabuhan->kode_pelabuhan,
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('operators', [
            'nama_operator' => 'New Operator',
            'no_hp' => '0898765432',
            'kode_pelabuhan' => $pelabuhan->kode_pelabuhan,
        ]);
    }

    public function test_user_can_update_a_operator(): void
    {
        $user = User::factory()->create();

        $pelabuhan1 = \App\Models\Pelabuhan::create([
            'nama_pelabuhan' => 'Test Port 1',
            'nama_pulau' => 'Batam',
            'nama_gudang' => 'Gudang 1'
        ]);

        $pelabuhan2 = \App\Models\Pelabuhan::create([
            'nama_pelabuhan' => 'Test Port 2',
            'nama_pulau' => 'Bintan',
            'nama_gudang' => 'Gudang 2'
        ]);

        $operator = Operator::create([
            'nama_operator' => 'Old Operator',
            'no_hp' => '0812345678',
            'kode_pelabuhan' => $pelabuhan1->kode_pelabuhan,
        ]);

        $response = $this->actingAs($user)->put("/operators/{$operator->kode_operator}", [
            'nama_operator' => 'Updated OperatorName',
            'no_hp' => '0899999999',
            'kode_pelabuhan' => $pelabuhan2->kode_pelabuhan,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('operators', [
            'kode_operator' => $operator->kode_operator,
            'nama_operator' => 'Updated OperatorName',
            'no_hp' => '0899999999',
            'kode_pelabuhan' => $pelabuhan2->kode_pelabuhan,
        ]);
    }

    public function test_user_can_delete_a_operator(): void
    {
        $user = User::factory()->create();

        $operator = Operator::create([
            'nama_operator' => 'Delete Operator',
            'no_hp' => '0812345678',
        ]);

        $response = $this->actingAs($user)->delete("/operators/{$operator->kode_operator}");

        $response->assertRedirect();

        $this->assertDatabaseMissing('operators', [
            'kode_operator' => $operator->kode_operator,
        ]);
    }
}
