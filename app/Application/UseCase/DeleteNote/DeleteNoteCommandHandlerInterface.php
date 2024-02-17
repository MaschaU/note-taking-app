<?php

namespace App\Application\UseCase\DeleteNote;

interface DeleteNoteCommandHandlerInterface
{
    public function handle(DeleteNoteCommand $command): void;
}
