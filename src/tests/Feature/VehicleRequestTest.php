<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehicleRequestTest extends TestCase
{
    public function testPostOk()
    {
        $response = $this->postJson(
            '/vehicles',
            ['modelYear' => 2018, 'manufacturer' => 'Audi', 'model' => 'A3']
        );
        $response->assertOk();
        $this->assertNotEmpty($response->json('Count'));
    }

    public function testPostErrorParameters()
    {
        $response = $this->postJson(
            '/vehicles',
            ['modelYear' => 2018, 'manufacturer' => 'Audi', 'model' => 'b4']
        );
        $response->assertOk();
        $this->assertEmpty($response->json('Count'));
    }

    public function testPostErrorJsonInvalid()
    {
        $response = $this->postJson(
            '/vehicles',
            ['manufacturer' => 'Audi', 'model' => 'A3']
        );
        $response->assertOk();
        $this->assertEmpty($response->json('Count'));
    }
}
