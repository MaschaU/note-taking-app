<?php

declare(strict_types=1);

namespace App\Domain\Model;

use App\Domain\ValueObject\NoteBody;
use App\Domain\ValueObject\NoteId;
use App\Domain\ValueObject\NoteTitle;

final class Note
{
    private const NOTE_TITLE = 'title';

    private const NOTE_BODY = 'body';

    private const NOTE_TAGS = 'tags';

    private const NOTE_ID = 'note_id';

    public function __construct(
        private readonly NoteTitle $noteTitle,
        private readonly NoteBody $noteBody,
        private readonly NoteId $noteId,
    ) {
    }

    public function getNoteTitle(): NoteTitle
    {
        return $this->noteTitle;
    }

    public function getNoteBody(): NoteBody
    {
        return $this->noteBody;
    }

    public function getNoteId(): NoteId
    {
        return $this->noteId;
    }

    public function toArray(): array
    {
        return [
            self::NOTE_TITLE => $this->noteTitle->toString(),
            self::NOTE_BODY => $this->noteBody->toString(),
            self::NOTE_ID => $this->noteId->toString(),
        ];
    }
}
