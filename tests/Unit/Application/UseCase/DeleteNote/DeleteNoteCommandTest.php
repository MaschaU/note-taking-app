<?php

declare(strict_types=1);

namespace Tests\Unit\Application\UseCase\DeleteNote;

use App\Application\UseCase\DeleteNote\DeleteNoteCommand;
use App\Domain\ValueObject\NoteId;
use Tests\TestCase;

final class DeleteNoteCommandTest extends TestCase
{
    private DeleteNoteCommand $command;
    private NoteId $noteId;
    private const NOTE_ID = 'eeadfe99-99f2-49e3-b0a2-65fdb7d2eea0';

    public function setUp(): void
    {
        parent::setUp();
        $this->noteId = NoteId::fromString(self::NOTE_ID);
    }

    public function testGetNoteId(): void
    {
        $this->whenICreateTheCommand();
        $this->thenICanAccessNoteId();
    }

    private function whenICreateTheCommand(): void
    {
        $this->command = new DeleteNoteCommand(
            $this->noteId,
        );
    }

    private function thenICanAccessNoteId(): void
    {
        $this->assertEquals($this->noteId, $this->command->noteId());
    }
}
