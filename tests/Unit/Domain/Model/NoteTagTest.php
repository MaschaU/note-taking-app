<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Model;

use App\Domain\Model\NoteTag;
use App\Domain\ValueObject\NoteId;
use App\Domain\ValueObject\TagId;
use PHPUnit\Framework\TestCase;

final class NoteTagTest extends TestCase
{
    private const NOTE_ID = 'eeadfe99-99f2-49e3-b0a2-65fdb7d2eea0';

    private const TAG_ID = 'eeadfe99-99f2-49e3-b0a2-65fdb7d2eea1';

    public function testGetters(): void
    {
        $noteTage = new NoteTag(
            NoteId::fromString(self::NOTE_ID),
            TagId::fromString(self::TAG_ID),
        );
        $this->assertEquals(self::NOTE_ID, $noteTage->getNoteId());
        $this->assertEquals(self::TAG_ID, $noteTage->getTagId());
    }

    public function testToArray(): void
    {
        $noteTag = new NoteTag(
            NoteId::fromString(self::NOTE_ID),
            TagId::fromString(self::TAG_ID),
        );
        $this->assertEquals(
            [
                'note_id' => self::NOTE_ID,
                'tag_id' => self::TAG_ID,
            ],
            $noteTag->toArray()
        );
    }
}
