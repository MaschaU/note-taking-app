<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\NoteId;
use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class NoteIdTest extends TestCase
{
    private const NOTE_ID = 'eeadfe99-99f2-49e3-b0a2-65fdb7d2eea0';

    public function testFromString(): void
    {
        $noteId = NoteId::fromString(self::NOTE_ID);
        $this->assertInstanceOf(NoteId::class, $noteId);
        $this->assertSame(self::NOTE_ID, $noteId->toString());
    }

    #[DataProvider('provideInvalidUuid')]
    public function testFromStringWithInvalidUuid(string $string): void
    {
        $this->expectException(InvalidArgumentException::class);
        NoteId::fromString($string);
    }

    public function testToStringMagicMethod(): void
    {
        $noteId = NoteId::fromString(self::NOTE_ID);
        $this->assertSame(self::NOTE_ID, (string) $noteId);
        $this->assertSame(self::NOTE_ID, (string) $noteId);
        $this->assertSame(self::NOTE_ID, sprintf('%s', $noteId));
    }

    /**
     * @return Generator<string, string[]>
     */
    public static function provideInvalidUuid(): Generator
    {
        yield 'Wrong uuid format' => [
            'Just a normal string',
        ];

        yield 'Empty string' => [
            '',
        ];
    }
}
