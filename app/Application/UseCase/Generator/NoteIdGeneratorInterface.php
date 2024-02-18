<?php

declare(strict_types=1);

namespace App\Application\UseCase\Generator;

use App\Domain\ValueObject\NoteId;

interface NoteIdGeneratorInterface
{
    public function generate(): NoteId;
}
