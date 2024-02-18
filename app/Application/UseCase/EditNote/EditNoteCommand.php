<?php

declare(strict_types=1);

namespace App\Application\UseCase\EditNote;

use App\Domain\ValueObject\NoteBody;
use App\Domain\ValueObject\NoteId;
use App\Domain\ValueObject\NoteTitle;

final class EditNoteCommand
{
    public function __construct(
        private readonly NoteId $noteId,
        private readonly NoteTitle $noteTitle,
        private readonly NoteBody $noteBody,
    ) {
    }

    public function noteId(): NoteId
    {
        return $this->noteId;
    }

    public function noteTitle(): NoteTitle
    {
        return $this->noteTitle;
    }

    public function noteBody(): NoteBody
    {
        return $this->noteBody;
    }
}
