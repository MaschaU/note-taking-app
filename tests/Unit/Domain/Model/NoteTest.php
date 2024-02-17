<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Model;

use App\Domain\Model\Note;
use App\Domain\ValueObject\NoteBody;
use App\Domain\ValueObject\NoteId;
use App\Domain\ValueObject\NoteTags;
use App\Domain\ValueObject\NoteTitle;
use PHPUnit\Framework\TestCase;

final class NoteTest extends TestCase
{
    private const NOTE_TITLE = 'Amazing note';

    private const NOTE_BODY = 'Such wow';

    private const NOTE_ID = 'eeadfe99-99f2-49e3-b0a2-65fdb7d2eea0';

    public function testGetters(): void
    {
        $note = new Note(
            NoteTitle::fromString(self::NOTE_TITLE),
            NoteBody::fromString(self::NOTE_BODY),
            NoteId::fromString(self::NOTE_ID),
        );
        $this->assertEquals(self::NOTE_TITLE, $note->getNoteTitle()->toString());
        $this->assertEquals(self::NOTE_BODY, $note->getNoteBody()->toString());
        $this->assertEquals(self::NOTE_ID, $note->getNoteId()->toString());
    }

    public function testToArray(): void
    {
        $note = new Note(
            NoteTitle::fromString(self::NOTE_TITLE),
            NoteBody::fromString(self::NOTE_BODY),
            NoteId::fromString(self::NOTE_ID),
        );
        $this->assertEquals(
            [
                'title' => self::NOTE_TITLE,
                'body' => self::NOTE_BODY,
                'note_id' => self::NOTE_ID,
            ], $note->toArray());
    }
}
