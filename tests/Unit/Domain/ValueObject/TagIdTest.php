<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\TagId;
use Generator;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class TagIdTest extends TestCase
{
    private const TAG_ID = 'eeadfe99-99f2-49e3-b0a2-65fdb7d2eea0';

    public function testFromString(): void
    {
        $noteId = TagId::fromString(self::TAG_ID);
        $this->assertInstanceOf(TagId::class, $noteId);
        $this->assertSame(self::TAG_ID, $noteId->toString());
    }

    #[DataProvider('provideInvalidUuid')]
    public function testFromStringWithInvalidUuid(string $string): void
    {
        $this->expectException(InvalidArgumentException::class);
        TagId::fromString($string);
    }

    public function testToStringMagicMethod(): void
    {
        $noteId = TagId::fromString(self::TAG_ID);
        $this->assertSame(self::TAG_ID, (string) $noteId);
        $this->assertSame(self::TAG_ID, (string) $noteId);
        $this->assertSame(self::TAG_ID, sprintf('%s', $noteId));
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
