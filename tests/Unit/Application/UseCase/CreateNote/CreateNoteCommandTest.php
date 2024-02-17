<?php

declare(strict_types=1);

namespace Tests\Unit\Application\UseCase\CreateNote;

use App\Application\UseCase\CreateNote\CreateNoteCommand;
use App\Domain\ValueObject\NoteBody;
use App\Domain\ValueObject\NoteId;
use App\Domain\ValueObject\NoteTags;
use App\Domain\ValueObject\NoteTitle;
use PHPUnit\Framework\TestCase;

final class CreateNoteCommandTest extends TestCase
{
    private CreateNoteCommand $command;

    private NoteTitle $noteTitle;

    private NoteBody $noteBody;

    private NoteTags $noteTags;

    private const NOTE_TITLE = 'Amazing note';

    private const NOTE_BODY = 'Such wow';

    private const NOTE_TAGS = ['wow', 'whoa'];



    public function setUp(): void
    {
        parent::setUp();
        $this->noteTitle = NoteTitle::fromString(self::NOTE_TITLE);
        $this->noteBody = NoteBody::fromString(self::NOTE_BODY);
        $this->noteTags = NoteTags::fromArray(self::NOTE_TAGS);
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

    public function testGetNoteTags(): void
    {
        $this->whenICreateTheCommand();
        $this->thenICanAccessNoteTags();
    }

    private function whenICreateTheCommand(): void
    {
        $this->command = new CreateNoteCommand(
            $this->noteTitle,
            $this->noteBody,
            $this->noteTags,
        );
    }

    private function thenICanAccessNoteTitle(): void
    {
        $this->assertEquals($this->noteTitle, $this->command->noteTitle());
    }

    private function thenICanAccessNoteBody(): void
    {
        $this->assertEquals($this->noteBody, $this->command->noteBody());
    }

    private function thenICanAccessNoteTags(): void
    {
        $this->assertEquals($this->noteTags, $this->command->noteTags());
    }
}
