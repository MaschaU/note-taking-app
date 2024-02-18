<?php

declare(strict_types=1);

namespace Tests\Unit\Application\UseCase\EditNote;

use App\Application\UseCase\EditNote\EditNoteCommand;
use App\Application\UseCase\EditNote\EditNoteCommandHandler;
use App\Application\UseCase\Exception\NoteNotFoundException;
use App\Domain\Repository\NotesRepositoryInterface;
use App\Domain\ValueObject\NoteBody;
use App\Domain\ValueObject\NoteId;
use App\Domain\ValueObject\NoteTitle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class EditNoteCommandHandlerTest extends TestCase
{
    use RefreshDatabase;
    private const NOTE_ID = 'eeadfe99-99f2-49e3-b0a2-65fdb7d2eea0';

    private const NOTE_TITLE = 'Mind blowing title';

    private const UPDATED_TITLE = 'Even better one';

    private const NOTE_BODY = 'what happened next will shock you';

    /**
     * @var MockObject&NotesRepositoryInterface
     */
    private MockObject $notesRepository;

    private EditNoteCommandHandler $commandHandler;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->notesRepository = $this->createMock(NotesRepositoryInterface::class);
        $this->commandHandler = new EditNoteCommandHandler(
            $this->notesRepository,
        );
    }

    public function testHandleUpdate(): void
    {
        $this->givenAnExistingNote();
        $this->expectNoteToBeEdited();
        $this->whenWeHandleEditNoteCommand();
    }

    public function testHandleThrowsException(): void
    {
        $this->givenNoExistingNote();
        $this->expectExceptionToBeThrown();
        $this->whenWeHandleEditNoteCommand();
    }

    private function givenAnExistingNote(): void
    {
        $this->notesRepository->expects(self::once())
            ->method('getByNoteId')
            ->with($this->noteId())
            ->willReturn([
                'title' => $this->noteTitle(),
                'body' => $this->noteBody(),
                'note_id' => $this->noteId(),
            ]);
    }

    private function givenNoExistingNote(): void
    {
        $this->notesRepository->expects(self::once())
            ->method('getByNoteId')
            ->with($this->noteId())
            ->willReturn(null);
    }

    private function expectExceptionToBeThrown(): void
    {
        $this->expectException(NoteNotFoundException::class);
    }

    private function expectNoteToBeEdited(): void
    {
        $this->notesRepository->expects(self::once())
            ->method('editNote')
            ->with($this->noteId(), $this->updatedTitle(), $this->noteBody());
    }

    private function whenWeHandleEditNoteCommand(): void
    {
        $this->commandHandler->handle($this->editNoteCommand());
    }

    private function editNoteCommand(): EditNoteCommand
    {
        return new EditNoteCommand(
            $this->noteId(),
            $this->updatedTitle(),
            $this->noteBody(),
        );
    }

    private function noteTitle(): NoteTitle
    {
        return NoteTitle::fromString(self::NOTE_TITLE);
    }

    private function updatedTitle(): NoteTitle
    {
        return NoteTitle::fromString(self::UPDATED_TITLE);
    }

    private function noteBody(): NoteBody
    {
        return NoteBody::fromString(self::NOTE_BODY);
    }

    private function noteId(): NoteId
    {
        return NoteId::fromString(self::NOTE_ID);
    }
}
