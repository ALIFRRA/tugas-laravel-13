<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuruApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_guru_api_returns_a_json_data_collection(): void
    {
        $response = $this->getJson('/api/guru');

        $response->assertOk()
            ->assertJsonStructure(['data']);
    }
}
