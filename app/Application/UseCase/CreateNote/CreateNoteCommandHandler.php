<?php

declare(strict_types=1);

namespace App\Application\UseCase\CreateNote;

use App\Application\UseCase\Generator\NoteIdGeneratorInterface;
use App\Application\UseCase\Generator\TagIdGeneratorInterface;
use App\Domain\Model\Note;
use App\Domain\Model\NoteTag;
use App\Domain\Repository\NotesRepositoryInterface;
use App\Domain\Repository\NoteTagRepositoryInterface;
use App\Domain\Repository\TagsRepositoryInterface;
use App\Domain\ValueObject\NoteBody;
use App\Domain\ValueObject\NoteTags;
use App\Domain\ValueObject\NoteTitle;
use App\Domain\ValueObject\TagLabel;

final class CreateNoteCommandHandler implements CreateNoteHandlerInterface
{
    public function __construct(
        private readonly NotesRepositoryInterface $notesRepository,
        private readonly TagsRepositoryInterface $tagsRepository,
        private readonly NoteIdGeneratorInterface $noteIdGenerator,
        private readonly TagIdGeneratorInterface $tagIdGenerator,
        private readonly NoteTagRepositoryInterface $noteTagRepository,
    ) {
    }

    // TODO: Implement database transaction for data integrity & consistency
    public function handle(CreateNoteCommand $command): void
    {
        // get tags if they already exist or insert them if not
        $noteTags = NoteTags::fromArray($command->noteTags()->toArray());
        $tags = [];
        foreach ($noteTags->toArray() as $tagLabel) {
            $currentTag = $this->tagsRepository->getByLabel(TagLabel::fromString($tagLabel));

            if (!$currentTag) {
                $tagId = $this->tagIdGenerator->generate();
                $tags[] = $this->tagsRepository->createTag(
                    $tagId,
                    TagLabel::fromString($tagLabel),
                );
            } else {
                $tags[] = $currentTag;
            }
        }

        // then insert note
        $noteId = $this->noteIdGenerator->generate();
        $noteData = new Note(
            NoteTitle::fromString($command->noteTitle()->toString()),
            NoteBody::fromString($command->noteBody()->toString()),
            $noteId,
        );
        $this->notesRepository->createNote($noteData);

        // in case we have tags, create relations between note and tags
        foreach ($tags as $tag) {
            // create tag_id, $note_id (id, is auto_increment by database)
            $noteTagRelation = new NoteTag(
                $noteId,
                $tag->getTagId(),
            );
            $this->noteTagRepository->createRelation($noteTagRelation);
        }
    }
}
