<?php

declare(strict_types=1);

namespace App\Application\UseCase\Exception;

use App\Domain\ValueObject\NoteId;
use RuntimeException;

final class NoteNotFoundException extends RuntimeException
{
    public static function forNoteId(NoteId $noteId): self
    {
        return new self(
            sprintf(
                'No notes with id "%s" found.',
                $noteId,
            ),
            404
        );
    }
}
