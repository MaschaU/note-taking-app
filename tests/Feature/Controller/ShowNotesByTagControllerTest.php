<?php

declare(strict_types=1);

namespace Tests\Feature\Controller;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class ShowNotesByTagControllerTest extends TestCase
{
    use RefreshDatabase;

    private const EXISTING_TAG_ID = 'a089205d-cc2f-4d43-9104-643bd1245b9e';

    private const NOT_EXISTING_TAG_ID = 'a080205d-cc2f-4d43-9104-643bd1145b9e';


    public function testShowNotesByTag(): void
    {
        $this->seed(DatabaseSeeder::class);
        $response = $this->getJson('/api/v1/show-notes-for-tag/'.self::EXISTING_TAG_ID);
        $response->assertStatus(200);
    }

    public function testUnsuccessful(): void
    {
        $response = $this->getJson('/api/v1/show-notes-for-tag/'.self::NOT_EXISTING_TAG_ID);
        $response->assertStatus(404);
    }
}
