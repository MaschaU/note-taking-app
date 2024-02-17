<?php

declare(strict_types=1);

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CreateNoteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateNote(): void
    {
        $requestData = [
            'title' => 'Linting',
            'body' => 'Add composer script for linting',
            'tags' => ['composer'],
        ];

        $response = $this->postJson('/api/v1/create-note', $requestData);

        $response->assertStatus(201);
        $response->assertJson(['message' => 'Note created successfully']);
    }

    public function testUnsuccessful(): void
    {
        $requestData = [];

        $response = $this->postJson('/api/v1/create-note', $requestData);

        $response->assertStatus(422);
    }
}
