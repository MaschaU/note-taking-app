<?php

declare(strict_types=1);

namespace App\Application\UseCase\EditNote;

interface EditNoteCommandHandlerInterface
{
    public function handle(EditNoteCommand $command): void;
}
