<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\NoteBody;
use PHPUnit\Framework\TestCase;

final class NoteBodyTest extends TestCase
{
    private const NOTE_BODY = 'An amazing note body';

    public function testToAndFromString(): void
    {
        $noteBody = NoteBody::fromString(self::NOTE_BODY);
        $this->assertInstanceOf(NoteBody::class, $noteBody);
        $this->assertEquals(self::NOTE_BODY, $noteBody->toString());
    }
}
