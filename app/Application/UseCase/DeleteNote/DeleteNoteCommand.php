<?php

declare(strict_types=1);

namespace App\Application\UseCase\DeleteNote;

use App\Domain\ValueObject\NoteId;

final class DeleteNoteCommand
{
    public function __construct(
        private readonly NoteId $noteId,
    ) {
    }

    public function noteId(): NoteId
    {
        return $this->noteId;
    }
}
