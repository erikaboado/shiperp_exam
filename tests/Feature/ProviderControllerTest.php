<?php

namespace Tests\Feature;

use App\Models\DataProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProviderControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_add_provider()
    {
        $data = [
            'name' => 'Test Data Provider',
            'url' => 'https://dog.ceo/api/breeds/image/random',
        ];

        $response = $this->post('/data_providers', $data);
        $response->assertOk();
        $this->assertDatabaseHas('data_providers', $data);
    }

    /** @test */
    public function can_update_provider()
    {
        $provider = DataProvider::factory()->create();

        $updatedData = [
            'name' => 'Updated Data Provider Name',
            'url' => 'https://randomfox.ca/floof/',
        ];

        $response = $this->put("/data_providers/{$provider->id}", $updatedData);

        $this->assertDatabaseHas('data_providers', $updatedData);
        $response->assertOk();
    }

    /** @test */
    public function can_delete_provider()
    {
        $provider = DataProvider::factory()->create();

        $response = $this->delete("/data_providers/{$provider->id}");

        $this->assertDeleted($provider);
        $response->assertOk();
    }
}
