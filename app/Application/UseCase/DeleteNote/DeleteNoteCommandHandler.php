<?php

declare(strict_types=1);

namespace App\Application\UseCase\DeleteNote;

use App\Application\UseCase\Exception\NoteNotFoundException;
use App\Domain\Repository\NotesRepositoryInterface;
use App\Domain\Repository\NoteTagRepositoryInterface;
use App\Domain\Repository\TagsRepositoryInterface;
use App\Domain\ValueObject\NoteId;

final class DeleteNoteCommandHandler implements DeleteNoteCommandHandlerInterface
{
    public function __construct(
        private readonly NotesRepositoryInterface $notesRepository,
        private readonly NoteTagRepositoryInterface $noteTagRepository,
        private readonly TagsRepositoryInterface $tagsRepository,
    ) {
    }

    // TODO: Implement database transaction for data integrity & consistency
    public function handle(DeleteNoteCommand $command): void
    {
        $noteId = NoteId::fromString($command->noteId()->toString());
        $note = $this->notesRepository->getByNoteId($noteId);
        if (!$note) {
            throw NoteNotFoundException::forNoteId($noteId);
        }

        // we need to remove the tags and the relations that are not needed anymore
        // check if these tags still have other notes or needs to be removed
        $tagIdsForDeletedRelations = $this->noteTagRepository
            ->deleteRelationsToNoteId($noteId);

        // delete tags by Id
        $this->tagsRepository->deleteByIds($tagIdsForDeletedRelations);

        // delete note
        $this->notesRepository->deleteNote($noteId);
    }
}
