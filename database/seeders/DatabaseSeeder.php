<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Helpers\CreateNoteTagTrait;
use App\Helpers\CreateNoteTrait;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use CreateNoteTrait;

    use CreateNoteTagTrait;

    private const TITLE_1 = 'Clickbait title';

    private const BODY_1 = 'You are not gonna believe this';

    private const UUID_1 = 'a089205d-cc2f-4d43-9104-643bd1245b9e';

    private const NOTE_ID = 'a089205d-cc2f-4d11-9104-643bd1245b9e';


    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        self::createNote(
            self::UUID_1,
            self::TITLE_1,
            self::BODY_1,
        );

        self::createNoteTag(
            self::NOTE_ID,
            self::UUID_1,
        );
    }
}
