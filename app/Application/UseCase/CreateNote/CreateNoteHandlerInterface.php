<?php

namespace App\Application\UseCase\CreateNote;

interface CreateNoteHandlerInterface
{
    public function handle(CreateNoteCommand $command): void;
}
