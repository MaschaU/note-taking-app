<?php

declare(strict_types=1);

namespace Tests\Unit\Integration;

use App\Domain\Model\Note;
use App\Domain\ValueObject\NoteBody;
use App\Domain\ValueObject\NoteId;
use App\Domain\ValueObject\NoteTitle;
use App\Infrastructure\Outbound\Persistance\Repository\NotesRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;


final class NotesRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private const NOTE_ID = 'a089205d-cc2f-4d43-9104-643bd1245b9e';

    private const NOTE_TITLE = 'Awesome title';

    private const NOTE_BODY = 'Even better body';

    private const SECOND_NOTE_ID = '75347c64-d3c2-414c-bc75-97f84b5dbfcc';

    private const SECOND_NOTE_TITLE = 'More awesome title';

    private const SECOND_NOTE_BODY = 'Even much better body';

    private const UPDATED_TITLE = 'New title';

    private NotesRepository $notesRepository;

    private Note $givenExistingNote;

    public function setUp(): void
    {
        parent::setUp();
        $this->notesRepository = $this->makeNotesRepository();
        $this->givenExistingNote = new Note(
            NoteTitle::fromString(self::NOTE_TITLE),
            NoteBody::fromString(self::NOTE_BODY),
            NoteId::fromString(self::NOTE_ID),
        );
        $this->givenSecondExisingNote = new Note(
            NoteTitle::fromString(self::SECOND_NOTE_TITLE),
            NoteBody::fromString(self::SECOND_NOTE_BODY),
            NoteId::fromString(self::SECOND_NOTE_ID),
        );
    }

    private function makeNotesRepository(): NotesRepository
    {
        /**
         * @var NotesRepository $notesRepository
         */
        $notesRepository = app(NotesRepository::class);

        $this->notesRepository = $notesRepository;
        self::assertInstanceOf(NotesRepository::class, $notesRepository);

        return $notesRepository;
    }

    public function testCreateNote(): void
    {
        $this->whenCreateNoteMethodIsCalled();
        $this->thenNoteIsPersistedInTheDatabase();
    }

    public function testGetAll(): void
    {
        $this->givenExistingNotes();
        $this->whenGetAllMethodIsCalled();
        $this->thenNotesAreReturned();
    }

    public function testGetNoteById(): void
    {
        $this->givenAnExistingNote();
        $this->whenGetByIdMethodIsCalled();
        $this->thenExistingNoteIsReturned();
    }

    public function getByNoteIds(): void
    {
        $this->givenExistingNotes();
        $this->whenGetByNoteIdsMethodIsCalled();
        $this->thenNotesWithSpecificIdAreReturned();
    }

    public function testDeleteNote(): void
    {
        $this->givenAnExistingNote();
        $this->whenDeleteNoteMethodIsCalled();
        $this->thenExistingNoteIsDeleted();
    }

    public function testEditNote(): void
    {
        $this->givenAnExistingNote();
        $this->whenEditNoteMethodIsCalled();
        $this->thenExistingNoteIsUpdated();
    }

    private function whenCreateNoteMethodIsCalled(): void
    {
        $this->notesRepository->createNote(
            new Note(
                NoteTitle::fromString(self::NOTE_TITLE),
                NoteBody::fromString(self::NOTE_BODY),
                NoteId::fromString(self::NOTE_ID),
            )
        );
    }

    private function thenNoteIsPersistedInTheDatabase(): void
    {
        $this->assertDatabaseHas(
            'notes',
            [
                'note_id' => self::NOTE_ID,
                'title' => self::NOTE_TITLE,
                'body' => self::NOTE_BODY,
            ]
        );
    }

    private function givenAnExistingNote(): void
    {
        $this->notesRepository->createNote($this->givenExistingNote);
    }

    private function whenGetAllMethodIsCalled(): Collection
    {
        return $this->notesRepository->getAll();
    }

    private function whenGetByIdMethodIsCalled(): void
    {
        $this->notesRepository->getByNoteId(NoteId::fromString(self::NOTE_ID));
    }

    private function whenGetByNoteIdsMethodIsCalled(): Collection
    {
        return $this->notesRepository->getByNoteIds([
            self::NOTE_ID,
            self::SECOND_NOTE_ID,
        ]);
    }

    private function givenExistingNotes(): void
    {
        $this->notesRepository->createNote($this->givenExistingNote);
        $this->notesRepository->createNote($this->givenSecondExisingNote);
    }

    private function thenExistingNoteIsReturned(): void
    {
        $this->assertEquals(
            [
                'title' => self::NOTE_TITLE,
                'body' => self::NOTE_BODY,
                'note_id' => self::NOTE_ID,
            ],
            $this->givenExistingNote->toArray()
        );
    }

    private function thenNotesAreReturned(): void
    {
        $collection = $this->whenGetAllMethodIsCalled()
            ->toArray();

        $expectedData = [
            (object)[
                'note_id' => self::NOTE_ID,
                'title' => self::NOTE_TITLE,
                'body' => self::NOTE_BODY
            ],
            (object)[
                'note_id' => self::SECOND_NOTE_ID,
                'title' => self::SECOND_NOTE_TITLE,
                'body' => self::SECOND_NOTE_BODY
            ],
        ];
        $this->assertEquals($expectedData, $collection);
    }

    public function thenNotesWithSpecificIdAreReturned(): void
    {
        $collection = $this->whenGetByNoteIdsMethodIsCalled()
            ->toArray();

        $expectedData = [
            (object)[
                'note_id' => self::NOTE_ID,
                'title' => self::NOTE_TITLE,
                'body' => self::NOTE_BODY
            ],
            (object)[
                'note_id' => self::SECOND_NOTE_ID,
                'title' => self::SECOND_NOTE_TITLE,
                'body' => self::SECOND_NOTE_BODY
            ],
        ];
        $this->assertEquals($expectedData, $collection);
    }

    private function whenDeleteNoteMethodIsCalled(): void
    {
        $this->notesRepository->deleteNote(NoteId::fromString(self::NOTE_ID));
    }

    private function thenExistingNoteIsDeleted(): void
    {
        $this->assertDatabaseMissing(
            'notes',
            [
                'title' => self::NOTE_TITLE,
                'body' => self::NOTE_BODY,
                'note_id' => self::NOTE_ID,
            ]
        );
    }

    private function whenEditNoteMethodIsCalled(): void
    {
        $this->notesRepository->editNote(NoteId::fromString(self::NOTE_ID), NoteTitle::fromString(self::UPDATED_TITLE), NoteBody::fromString(self::NOTE_BODY));
    }

    private function thenExistingNoteIsUpdated(): void
    {
        $this->assertDatabaseHas(
            'notes',
            [
                'note_id' => self::NOTE_ID,
                'title' => self::UPDATED_TITLE,
                'body' => self::NOTE_BODY,
            ]
        );
    }
}
