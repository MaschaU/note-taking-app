<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Model;

use App\Domain\Model\Tag;
use App\Domain\ValueObject\TagId;
use App\Domain\ValueObject\TagLabel;
use Tests\TestCase;

final class TagTest extends TestCase
{
    private const TAG_LABEL = '[wow]';

    private const TAG_ID = 'eeadfe99-99f2-49e3-b0a2-65fdb7d2eea0';

    public function testGetters(): void
    {
        $tag = new Tag(
            TagId::fromString(self::TAG_ID),
            TagLabel::fromString(self::TAG_LABEL),
        );
        $this->assertEquals(self::TAG_ID, $tag->getTagId());
        $this->assertEquals(self::TAG_LABEL, $tag->getTagLabel());
    }

    public function testToArray(): void
    {
        $tag = new Tag(
            TagId::fromString(self::TAG_ID),
            TagLabel::fromString(self::TAG_LABEL),
        );
        $this->assertEquals(
            [
            'label' => self::TAG_LABEL,
            'tag_id' => self::TAG_ID,
            ],
            $tag->toArray()
        );
    }
}
