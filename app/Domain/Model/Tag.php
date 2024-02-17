<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\ValueObject\NoteBody;
use App\Domain\ValueObject\TagId;
use App\Domain\ValueObject\NoteTitle;
use App\Domain\ValueObject\NoteTags;
use App\Domain\ValueObject\TagLabel;

final class Tag
{
    private const TAG_LABEL = 'label';

    private const TAG_ID = 'tag_id';

    public function __construct(
        private readonly TagId $tagId,
        private readonly TagLabel $tagLabel,
    ) {
    }

    public function getTagLabel(): TagLabel
    {
        return $this->tagLabel;
    }

    public function getTagId(): TagId
    {
        return $this->tagId;
    }

    public function toArray(): array
    {
        return [
            self::TAG_ID => $this->tagId->toString(),
            self::TAG_LABEL => $this->tagLabel->toString(),
        ];
    }
}
