<?php

declare(strict_types=1);

namespace App\Infrastructure\System;

use App\Application\UseCase\Generator\NoteIdGeneratorInterface;
use App\Application\UseCase\Generator\TagIdGeneratorInterface;
use App\Domain\ValueObject\NoteId;
use App\Domain\ValueObject\TagId;
use Ramsey\Uuid\Uuid;

final class TagIdGenerator implements TagIdGeneratorInterface
{

    public function generate(): TagId
    {
        return TagId::fromString(Uuid::uuid4()->toString());
    }
}
