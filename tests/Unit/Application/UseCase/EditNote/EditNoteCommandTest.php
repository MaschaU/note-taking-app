<?php

namespace Tests\Unit\Application\UseCase\EditNote;

use App\Application\UseCase\EditNote\EditNoteCommand;
use App\Domain\ValueObject\NoteBody;
use App\Domain\ValueObject\NoteId;
use App\Domain\ValueObject\NoteTags;
use App\Domain\ValueObject\NoteTitle;
use PHPUnit\Framework\TestCase;

final class EditNoteCommandTest extends TestCase
{
    private EditNoteCommand $command;
    private NoteId $noteId;

    private NoteTitle $noteTitle;

    private NoteBody $noteBody;
    private NoteTags $noteTags;
    private const NOTE_ID = 'eeadfe99-99f2-49e3-b0a2-65fdb7d2eea0';

    private const NOTE_TITLE = 'Mind blowing title';

    private const NOTE_BODY = 'what happened next will shock you';

    public function setUp(): void
    {
        parent::setUp();
        $this->noteId = NoteId::fromString(self::NOTE_ID);
        $this->noteTitle = NoteTitle::fromString(self::NOTE_TITLE);
        $this->noteBody = NoteBody::fromString(self::NOTE_BODY);
    }

    public function testGetNoteId(): void
    {
        $this->whenICreateTheCommand();
        $this->thenICanAccessNoteId();
    }

    public function testGetNoteTitle(): void
    {
        $this->whenICreateTheCommand();
        $this->thenICanAccessNoteTitle();
    }

    public function testGetNoteBody(): void
    {
        $this->whenICreateTheCommand();
        $this->thenICanAccessNoteBody();
    }

    private function whenICreateTheCommand(): void
    {
        $this->command = new EditNoteCommand(
            $this->noteId,
            $this->noteTitle,
            $this->noteBody,
        );
    }

    private function thenICanAccessNoteId(): void
    {
        $this->assertEquals($this->noteId, $this->command->noteId());
    }

    private function thenICanAccessNoteTitle(): void
    {
        $this->assertEquals($this->noteTitle, $this->command->noteTitle());
    }

    private function thenICanAccessNoteBody(): void
    {
        $this->assertEquals($this->noteBody, $this->command->noteBody());
    }
}
