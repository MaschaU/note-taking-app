<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\NoteTitle;
use PHPUnit\Framework\TestCase;

final class NoteTitleTest extends TestCase
{
    private const NOTE_TITLE = 'Be amazed title';

    public function testToAndFromString(): void
    {
        $noteTitle = NoteTitle::fromString(self::NOTE_TITLE);
        $this->assertInstanceOf(NoteTitle::class, $noteTitle);
        $this->assertEquals(self::NOTE_TITLE, $noteTitle->toString());
    }
}
