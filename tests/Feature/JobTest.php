<?php

namespace Tests\Feature;

use App\Job;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class JobTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testCreateJob()
    {
        $this->withoutExceptionHandling();

        $attributes = $this->fakeAttributes();

        $this->post('/job', $attributes);
        $this->assertDatabaseHas('jobs', $attributes);
        $this->get('/job')->assertSee($attributes['company_name']);
    }

    public function testRequiredName()
    {
        $attributes = $this->fakeAttributes();
        $attributes['description'] = '';

        $response = $this->post('/job', $attributes);

        $response->assertSessionHasErrors('description');
    }

    public function testRequiredDescription()
    {
        $attributes = $this->fakeAttributes();
        $attributes['company_name'] = '';

        $response = $this->post('/job', $attributes);

        $response->assertSessionHasErrors('company_name');
    }

    public function testEditJob()
    {
        $this->withoutExceptionHandling();

        $attributes = $this->fakeAttributes();
        $this->post('/job', $attributes);

        $id = Job::first()->id;

        $response = $this->patch('/job/' . $id, [
            'company_name' => 'Biro',
            'description' => 'Descrição massa!'
        ]);

        $this->assertEquals('Biro', Job::first()->company_name);
        $this->assertEquals('Descrição massa!', Job::first()->description);
    }

    protected function fakeAttributes()
    {
        return [
            'company_name' => $this->faker->name,
            'description' => $this->faker->paragraph,
            'role' => $this->faker->name,
            'level' => $this->faker->sentence,
            'requirements' => $this->faker->paragraph,
            'location' => $this->faker->sentence,
            'benefits' => $this->faker->sentence,
        ];
    }
}
