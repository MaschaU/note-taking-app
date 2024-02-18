<?php

declare(strict_types=1);

namespace Tests\Unit\Application\UseCase\CreateNote;

use App\Application\UseCase\CreateNote\CreateNoteCommand;
use App\Application\UseCase\CreateNote\CreateNoteCommandHandler;
use App\Application\UseCase\Generator\NoteIdGeneratorInterface;
use App\Application\UseCase\Generator\TagIdGeneratorInterface;
use App\Domain\Model\Note;
use App\Domain\Model\NoteTag;
use App\Domain\Model\Tag;
use App\Domain\Repository\NotesRepositoryInterface;
use App\Domain\Repository\NoteTagRepositoryInterface;
use App\Domain\Repository\TagsRepositoryInterface;
use App\Domain\ValueObject\NoteBody;
use App\Domain\ValueObject\NoteId;
use App\Domain\ValueObject\NoteTags;
use App\Domain\ValueObject\NoteTitle;
use App\Domain\ValueObject\TagId;
use App\Domain\ValueObject\TagLabel;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class CreateNoteCommandHandlerTest extends TestCase
{
    private const NOTE_TITLE = 'Amazing note';

    private const NOTE_BODY = 'Such wow';

    private const NOTE_TAGS = ['whoa'];

    private const NOTE_ID = 'eeadfe99-99f2-49e3-b0a2-65fdb7d2eea0';

    private const TAG_ID = 'eeadfe99-99f2-49e3-b0a2-65fdb7d2eea1';

    private const TAG_LABEL = 'whoa';

    /**
     * @var MockObject&NotesRepositoryInterface
     */
    private MockObject $noteRepository;
    /**
     * @var MockObject&TagsRepositoryInterface
     */
    private MockObject $tagsRepository;

    /**
     * @var MockObject&NoteTagRepositoryInterface
     */
    private MockObject $noteTagRepository;

    /**
     * @var MockObject&NoteIdGeneratorInterface
     */
    private MockObject $noteIdGenerator;

    /**
     * @var MockObject&TagIdGeneratorInterface
     */
    private MockObject $tagIdGenerator;

    private CreateNoteCommandHandler $commandHandler;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->noteRepository = $this->createMock(NotesRepositoryInterface::class);
        $this->tagsRepository = $this->createMock(TagsRepositoryInterface::class);
        $this->noteTagRepository = $this->createMock(NoteTagRepositoryInterface::class);
        $this->noteIdGenerator = $this->createMock(NoteIdGeneratorInterface::class);
        $this->tagIdGenerator = $this->createMock(TagIdGeneratorInterface::class);
        $this->noteIdGenerator->expects($this->once())
            ->method('generate')
            ->withAnyParameters()
            ->willReturn($this->noteId());
        $this->commandHandler = new CreateNoteCommandHandler(
            $this->noteRepository,
            $this->tagsRepository,
            $this->noteIdGenerator,
            $this->tagIdGenerator,
            $this->noteTagRepository,
        );
    }

    public function testHandleCreateNotes(): void
    {
        $this->givenNoTagsInTheDatabase();
        $this->expectNewTagsToBePersisted();
        $this->expectNoteToBePersisted();
        $this->andRelationsToBePersisted();
        $this->whenWeHandleCreateNoteCommand();
    }

    public function testHandleCreateNotesWithExistingTags(): void
    {
        $this->givenExistingTagsInTheDatabase();
        $this->expectNoteToBePersisted();
        $this->andRelationsToBePersisted();
        $this->whenWeHandleCreateNoteCommand();
    }

    private function givenExistingTagsInTheDatabase(): void
    {
        $this->tagsRepository->expects(self::once())
            ->method('getByLabel')
            ->with($this->tagLabel())
            ->willReturn(new Tag(
                $this->tagId(),
                $this->tagLabel()
            ));
    }

    private function givenNoTagsInTheDatabase(): void
    {
        $this->tagsRepository->expects(self::once())
            ->method('getByLabel')
            ->with($this->tagLabel())
            ->willReturn(null);
    }

    private function expectNoteToBePersisted(): void
    {

        $this->noteRepository->expects(self::once())
            ->method('createNote')
            ->with(new Note(
                $this->noteTitle(),
                $this->noteBody(),
                $this->noteId(),
            ));

    }

    private function expectNewTagsToBePersisted(): void
    {
        $this->tagIdGenerator->expects(self::once())
            ->method('generate')
            ->willReturn(TagId::fromString(self::TAG_ID));

        $this->tagsRepository->expects(self::once())
            ->method('createTag')
            ->with(
                $this->tagId(),
                $this->tagLabel()
            )
            ->willReturn(
                new Tag(
                    $this->tagId(),
                    $this->tagLabel()
                )
            );
    }

    private function andRelationsToBePersisted(): void
    {
        $this->noteTagRepository->expects(self::once())
            ->method('createRelation')
            ->with(new NoteTag(
                $this->noteId(),
                $this->tagId()
            ));
    }

    private function createNoteCommand(): CreateNoteCommand
    {
        return new CreateNoteCommand(
            $this->noteTitle(),
            $this->noteBody(),
            $this->noteTags(),
        );
    }

    private function noteTitle(): NoteTitle
    {
        return NoteTitle::fromString(self::NOTE_TITLE);
    }

    private function noteBody(): NoteBody
    {
        return NoteBody::fromString(self::NOTE_BODY);
    }

    private function noteTags(): NoteTags
    {
        return NoteTags::fromArray(self::NOTE_TAGS);
    }

    private function noteId(): NoteId
    {
        return NoteId::fromString(self::NOTE_ID);
    }

    private function tagId(): TagId
    {
        return TagId::fromString(self::TAG_ID);
    }

    private function tagLabel(): TagLabel
    {
        return TagLabel::fromString(self::TAG_LABEL);
    }

    private function whenWeHandleCreateNoteCommand(): void
    {
        $this->commandHandler->handle($this->createNoteCommand());
    }
}
