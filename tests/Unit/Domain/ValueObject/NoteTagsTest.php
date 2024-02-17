<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\NoteTags;
use PHPUnit\Framework\TestCase;

final class NoteTagsTest extends TestCase
{
    private const TAGS_ARRAY = [
        'tag_one',
        'tag_two',
        'tag_three',
    ];

    public function testFromArray(): void
    {
        $noteTags = NoteTags::fromArray(self::TAGS_ARRAY);
        $this->assertInstanceOf(NoteTags::class, $noteTags);
        $this->assertEquals(self::TAGS_ARRAY, $noteTags->toArray());
    }

    public function testToArray(): void
    {
        $this->assertEquals(self::TAGS_ARRAY, NoteTags::fromArray(self::TAGS_ARRAY)->toArray());
    }
}
