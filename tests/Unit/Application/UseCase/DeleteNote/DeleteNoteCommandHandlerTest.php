<?php

declare(strict_types=1);

namespace Tests\Unit\Application\UseCase\DeleteNote;

use App\Application\UseCase\DeleteNote\DeleteNoteCommand;
use App\Application\UseCase\DeleteNote\DeleteNoteCommandHandler;
use App\Application\UseCase\Exception\NoteNotFoundException;
use App\Application\UseCase\Generator\NoteIdGeneratorInterface;
use App\Domain\Model\Note;
use App\Domain\Repository\NotesRepositoryInterface;
use App\Domain\Repository\NoteTagRepositoryInterface;
use App\Domain\Repository\TagsRepositoryInterface;
use App\Domain\ValueObject\NoteBody;
use App\Domain\ValueObject\NoteId;
use App\Domain\ValueObject\NoteTitle;
use App\Domain\ValueObject\TagId;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class DeleteNoteCommandHandlerTest extends TestCase
{
    private const NOTE_ID = 'eeadfe99-99f2-49e3-b0a2-65fdb7d2eea0';

    private const TAG_ID = '8c0b19f5-beee-496d-9970-aaf04f8829cb';
    private const TAG_LABEL = 'Engineering';

    private const NOTE_TITLE = 'Mind blowing title';

    private const NOTE_BODY = 'what happened next will shock you';

    /**
     * @var MockObject&NotesRepositoryInterface
     */
    private MockObject $notesRepository;

    /**
     * @var MockObject&NoteTagRepositoryInterface
     */
    private MockObject $noteTagRepository;

    /**
     * @var MockObject&TagsRepositoryInterface
     */
    private MockObject $tagsRepository;

    /**
     * @var MockObject&NoteIdGeneratorInterface
     */
    private MockObject $noteIdGenerator;

    private DeleteNoteCommandHandler $commandHandler;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->notesRepository = $this->createMock(NotesRepositoryInterface::class);
        $this->noteTagRepository = $this->createMock(NoteTagRepositoryInterface::class);
        $this->tagsRepository = $this->createMock(TagsRepositoryInterface::class);
        $this->noteIdGenerator = $this->createMock(NoteIdGeneratorInterface::class);
        $this->commandHandler = new DeleteNoteCommandHandler(
            $this->notesRepository,
            $this->noteTagRepository,
            $this->tagsRepository,
        );
    }

    public function testHandleThrowsException(): void
    {
        $this->givenNoExistingNote();
        $this->expectNoteNotFoundException();
        $this->whenWeHandleDeleteNoteCommand();
    }

    public function testHandle(): void
    {
        $this->givenAnExistingNote();
        $this->expectRelationToNoteIdToBeDeleted();
        $this->expectTagsToBeDeleted();
        $this->whenWeHandleDeleteNoteCommand();
    }

    private function givenAnExistingNote(): void
    {
        $this->notesRepository->expects(self::once())
            ->method('getByNoteId')
            ->with($this->noteId())
            ->willReturn([
                $this->noteTitle(),
                $this->noteBody(),
                $this->noteId(),
            ]);
    }

    private function expectRelationToNoteIdToBeDeleted(): void
    {
        $this->noteTagRepository->expects(self::once())
            ->method('deleteRelationsToNoteId')
            ->with($this->noteId())
            ->willReturn([self::TAG_ID]);
    }

    private function expectTagsToBeDeleted(): void
    {
        $this->tagsRepository->expects(self::once())
            ->method('deleteByIds')
            ->with([self::TAG_ID]);
    }

    private function whenWeHandleDeleteNoteCommand(): void
    {
        $this->commandHandler->handle($this->deleteNoteCommand());
    }

    private function expectNoteNotFoundException(): void
    {
        $this->expectException(NoteNotFoundException::class);
    }

    private function deleteNoteCommand(): DeleteNoteCommand
    {
        return new DeleteNoteCommand(
            $this->noteId(),
        );
    }

    private function noteId(): NoteId
    {
        return NoteId::fromString(self::NOTE_ID);
    }

    private function noteTitle(): NoteTitle
    {
        return NoteTitle::fromString(self::NOTE_TITLE);
    }

    private function noteBody(): NoteBody
    {
        return NoteBody::fromString(self::NOTE_BODY);
    }

    private function tagId(): TagId
    {
        return TagId::fromString(self::TAG_ID);
    }

    private function givenNoExistingNote(): void
    {
        $this->notesRepository->expects(self::once())
            ->method('getByNoteId')
            ->with(self::NOTE_ID)
            ->willReturn(null);
    }



}
