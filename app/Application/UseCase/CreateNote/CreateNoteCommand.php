<?php

declare(strict_types=1);

namespace App\Application\UseCase\CreateNote;

use App\Domain\ValueObject\NoteBody;
use App\Domain\ValueObject\NoteTags;
use App\Domain\ValueObject\NoteTitle;

final class CreateNoteCommand
{
    public function __construct(
        private readonly NoteTitle $noteTitle,
        private readonly NoteBody $noteBody,
        private readonly NoteTags $noteTags,
    ){
    }

    public function noteTitle(): NoteTitle
    {
        return $this->noteTitle;
    }

    public function noteBody(): NoteBody
    {
        return $this->noteBody;
    }

    public function noteTags(): NoteTags
    {
        return $this->noteTags;
    }
}
