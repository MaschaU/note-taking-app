<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Domain\Model\Note;
use App\Domain\ValueObject\NoteBody;
use App\Domain\ValueObject\NoteId;
use App\Domain\ValueObject\NoteTags;
use App\Domain\ValueObject\NoteTitle;
use App\Infrastructure\Outbound\Persistance\Repository\NotesRepository;

trait CreateNoteTrait
{
    public static function createNote(
        string $noteId,
        string $noteTitle,
        string $noteBody,
    ): void {
        /**
         * @var NotesRepository $repository
         */
        $repository = app(NotesRepository::class);
        $repository->createNote(
            new Note(
                NoteTitle::fromString($noteTitle),
                NoteBody::fromString($noteBody),
                NoteId::fromString($noteId),
            )
        );
    }
}
