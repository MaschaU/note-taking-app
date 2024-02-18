<?php

declare(strict_types=1);

namespace App\Application\UseCase\EditNote;

use App\Application\UseCase\Exception\NoteNotFoundException;
use App\Domain\Repository\NotesRepositoryInterface;

final class EditNoteCommandHandler implements EditNoteCommandHandlerInterface
{
    public function __construct(
        private readonly NotesRepositoryInterface $notesRepository,
    ) {
    }

    public function handle(EditNoteCommand $command): void
    {
        $noteId = $command->noteId();
        $note = $this->notesRepository->getByNoteId($noteId);
        if (!$note) {
            throw NoteNotFoundException::forNoteId($noteId);
        }

        // TODO: Implement logic to change the tags and relations (add/remove, no update because it could interfere with other notes)

        // update title and/or body
        $noteTitle = $command->noteTitle();
        $noteBody = $command->noteBody();
        $this->notesRepository->editNote($noteId, $noteTitle, $noteBody);
    }
}
