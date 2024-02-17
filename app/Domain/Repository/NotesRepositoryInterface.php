<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Note;
use App\Domain\ValueObject\NoteBody;
use App\Domain\ValueObject\NoteId;
use App\Domain\ValueObject\NoteTitle;
use Illuminate\Support\Collection;

interface NotesRepositoryInterface
{
    public function createNote(Note $note): void;

    public function getAll(): Collection;

    public function getByNoteId(NoteId $noteId): ?array;

    public function getByNoteIds(array $noteIds): Collection;

    public function deleteNote(NoteId $noteId): void;

    public function editNote(NoteId $noteId, ?NoteTitle $noteTitle, ?NoteBody $noteBody): void;
}
