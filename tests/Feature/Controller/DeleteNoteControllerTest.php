<?php

declare(strict_types=1);

namespace Tests\Feature\Controller;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class DeleteNoteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testDeleteNote()
    {
        $this->seed(DatabaseSeeder::class);

        $requestData = [
            'note_id' => 'a089205d-cc2f-4d43-9104-643bd1245b9e',
        ];

        $response = $this->postJson('/api/v1/delete-note', $requestData);
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Note deleted successfully']);
    }

    public function testUnsuccessful(): void
    {
        $requestData = [
            'note_id' => 'a089211d-cc2f-4d43-9104-643bd1245b9e',
        ];

        $response = $this->deleteJson('/api/v1/delete-note', $requestData);

        $response->assertStatus(405);
    }
}
