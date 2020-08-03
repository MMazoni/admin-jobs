<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testCreateJob()
    {
        $this->withoutExceptionHandling();

        $attributes = [
            'company_name' => $this->faker->name,
            'description' => $this->faker->paragraph,
            'role' => $this->faker->name,
            'level' => $this->faker->sentence,
            'requirements' => $this->faker->paragraph,
            'location' => $this->faker->sentence,
            'benefits' => $this->faker->sentence,
        ];

        $this->post('/job', $attributes);
        $this->assertDatabaseHas('jobs', $attributes);
        $this->get('/job')->assertSee($attributes['company_name']);
    }

    public function testRequiredName()
    {
        $response = $this->post('/job', [
            'company_name' => $this->faker->name,
            'description' => '',
            'role' => $this->faker->name,
            'level' => $this->faker->sentence,
            'requirements' => $this->faker->paragraph,
            'location' => $this->faker->sentence,
            'benefits' => $this->faker->sentence,
        ]);

        $response->assertSessionHasErrors('description');
    }

    public function testRequiredDescription()
    {
        $response = $this->post('/job', [
            'company_name' => '',
            'description' => $this->faker->paragraph,
            'role' => $this->faker->name,
            'level' => $this->faker->sentence,
            'requirements' => $this->faker->paragraph,
            'location' => $this->faker->sentence,
            'benefits' => $this->faker->sentence,
        ]);

        $response->assertSessionHasErrors('company_name');
    }
}
