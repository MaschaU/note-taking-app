<?php

namespace App\Domain\Model;

use App\Domain\ValueObject\NoteId;
use App\Domain\ValueObject\TagId;

final class NoteTag
{
    private const NOTE_ID = 'note_id';
    private const TAG_ID = 'tag_id';

    public function __construct(
        private readonly NoteId $noteId,
        private readonly TagId $tagId,
    ) {
    }

    public function getNoteId(): NoteId
    {
        return $this->noteId;
    }

    public function getTagId(): TagId
    {
        return $this->tagId;
    }

    public function toArray(): array
    {
        return [
          self::NOTE_ID => $this->noteId,
          self::TAG_ID => $this->tagId,
        ];
    }

}
