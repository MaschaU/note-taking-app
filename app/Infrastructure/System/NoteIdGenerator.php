<?php

declare(strict_types=1);

namespace App\Infrastructure\System;

use App\Application\UseCase\Generator\NoteIdGeneratorInterface;
use App\Domain\ValueObject\NoteId;
use Ramsey\Uuid\Uuid;

final class NoteIdGenerator implements NoteIdGeneratorInterface
{

    public function generate(): NoteId
    {
        return NoteId::fromString(Uuid::uuid4()->toString());
    }
}
