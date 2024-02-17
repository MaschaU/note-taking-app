<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Domain\Model\NoteTag;
use App\Domain\ValueObject\NoteId;
use App\Domain\ValueObject\TagId;
use App\Infrastructure\Outbound\Persistance\Repository\NoteTagRepository;

trait CreateNoteTagTrait
{
    public static function createNoteTag(
        string $noteId,
        string $tagId,
    ): void {
        /**
         * @var NoteTagRepository $repository
         */
        $repository = app(NoteTagRepository::class);
        $repository->createRelation(
            new NoteTag(
                NoteId::fromString($noteId),
                TagId::fromString($tagId),
            )
        );
    }
}
