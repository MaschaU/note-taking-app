<?php

declare(strict_types=1);

namespace Tests\Feature\Controller;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class EditNoteControllerTest extends TestCase
{
    use RefreshDatabase;
    private const NOTE_ID = 'a089205d-cc2f-4d43-9104-643bd1245b9e';

    private const BODY = 'Such wow';

    private const TITLE = 'Brand new title';

    private const NON_EXISTING_TAG_ID = 'a080205d-cc2f-4d43-9104-643bd1145b9e';

    public function testDeleteNote()
    {
        $this->seed(DatabaseSeeder::class);
        $requestData = [
            'note_id' => self::NOTE_ID,
            'title' => self::TITLE,
            'body' => self::BODY,
        ];

        $response = $this->postJson('/api/v1/edit-note', $requestData);
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Note edited successfully']);
    }

    public function testUnsuccessful(): void
    {
        $requestData = [
            'note_id' => self::NON_EXISTING_TAG_ID,
            'title' => 'Brand new title',
        ];

        $response = $this->deleteJson('/api/v1/edit-note', $requestData);

        $response->assertStatus(405);
    }
}
