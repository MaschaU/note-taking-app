<?php

declare(strict_types=1);

namespace Tests\Feature\Controller;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ShowNotesControllerTest extends TestCase
{
    use RefreshDatabase;

    private const TITLE = 'Clickbait title';

    private const BODY = 'You are not gonna believe this';

    private const UUID = 'a089205d-cc2f-4d43-9104-643bd1245b9e';

    public function testShowNotes()
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->getJson('/api/v1/show-notes');
        $response->assertStatus(200);

        $this->assertEquals(json_encode(
            [
                [
                'note_id' => self::UUID,
                'title' => self::TITLE,
                'body' => self::BODY,
                ],
            ]
        ), $response->content());
    }
}
