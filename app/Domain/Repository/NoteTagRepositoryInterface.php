<?php

namespace App\Domain\Repository;

use App\Domain\Model\NoteTag;
use App\Domain\ValueObject\NoteId;
use App\Domain\ValueObject\TagId;
use Illuminate\Support\Collection;

interface NoteTagRepositoryInterface
{
    public function createRelation(NoteTag $noteTagRelation): void;

    public function deleteByNoteId(NoteId $noteId): void;

    public function deleteRelationsToNoteId(NoteId $noteId): ?array;

    public function getIsolatedTagsByNoteId(NoteId $noteId): Collection;

    public function getNoteIdsByTagId(TagId $tagId): Collection;

    public function getTagIdsByNoteId(NoteId $noteId): ?array;
}
