<?php

namespace Tests\Feature;

use App\Models\DataProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DataProviderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_provider()
    {
        $providerData = [
            'name' => 'Test Data Provider',
            'url' => 'https://dog.ceo/api/breeds/image/random',
        ];

        $provider = DataProvider::create($providerData);

        $this->assertDatabaseHas('data_providers', $providerData);
        $this->assertInstanceOf(DataProvider::class, $provider);
    }

    /** @test */
    public function can_update_provider()
    {
        // $providerData = [
        //     'name' => 'Test Data Provider',
        //     'url' => 'https://dog.ceo/api/breeds/image/random',
        // ];

        // $provider = DataProvider::create($providerData);
        $provider = DataProvider::factory()->create();

        $updatedData = [
            'name' => 'Updated Data Provider Name',
            'url' => 'https://randomfox.ca/floof/',
        ];

        $provider->update($updatedData);

        $this->assertDatabaseHas('data_providers', $updatedData);
    }

    /** @test */
    public function can_delete_provider()
    {
        // $providerData = [
        //     'name' => 'Test Data Providers',
        //     'url' => 'https://dog.ceo/api/breeds/image/random',
        // ];

        // $provider = DataProvider::create($providerData);
        $provider = DataProvider::factory()->create();

        $provider->delete();

        $this->assertDeleted($provider);
    }
}
