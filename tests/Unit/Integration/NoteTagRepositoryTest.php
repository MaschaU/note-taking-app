<?php

declare(strict_types=1);

namespace Tests\Unit\Integration;

use App\Domain\Model\Note;
use App\Domain\Model\NoteTag;
use App\Domain\ValueObject\NoteBody;
use App\Domain\ValueObject\NoteId;
use App\Domain\ValueObject\NoteTitle;
use App\Domain\ValueObject\TagId;
use App\Domain\ValueObject\TagLabel;
use App\Infrastructure\Outbound\Persistance\Repository\NotesRepository;
use App\Infrastructure\Outbound\Persistance\Repository\NoteTagRepository;
use App\Infrastructure\Outbound\Persistance\Repository\TagsRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class NoteTagRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private const NOTE1_CONTAINS_TAG1_TAG2 = '1709e9df-34a6-4285-9cd4-cd5c040b987b';

    private const NOTE2_CONTAINS_TAG1_TAG3 = '2f84eab7-bf6a-428c-a74b-5c141e809414';

    private const NOTE_TITLE = 'Awesome title';

    private const NOTE_BODY = 'Even better body';

    private const TAG_ID_1 = '01451b28-ea98-4994-ad5a-4fd2f543ced2';

    private const TAG_ID_2 = 'e3f70045-e871-41d6-88a1-b7664f636fa4';

    private const TAG_ID_3 = 'be0b9875-68b4-42b3-b045-ace80f57f25e';

    private const LABEL = 'wow';

    private NoteTagRepository $noteTagRepository;

    private NotesRepository $notesRepository;

    private TagsRepository $tagsRepository;

    private Note $givenExistingNote;

    private Note $givenSecondExisingNote;

    public function setUp(): void
    {
        parent::setUp();
        $this->noteTagRepository = $this->makeNoteTagRepository();
        $this->notesRepository = $this->makeNotesRepository();
        $this->tagsRepository = $this->makeTagsRepository();
        $this->givenExistingNote = new Note(
            NoteTitle::fromString(self::NOTE_TITLE),
            NoteBody::fromString(self::NOTE_BODY),
            NoteId::fromString(self::NOTE1_CONTAINS_TAG1_TAG2),
        );
    }

    public function testCreateRelation(): void
    {
        $this->givenExistingTagAndRelatedNote();
        $this->whenCreateRelationMethodIsCalled();
        $this->thenRelationIsPersisted();
    }

    public function testDeleteByNoteId(): void
    {
        $this->givenExistingRelation();
        $this->whenDeleteByNoteIdMethodIsCalled();
        $this->thenRelationIsDeleted();
    }

    public function testDeleteRelationsToNoteId(): void
    {
        $this->givenMultipleExistingRelationsAndOneUnrelatedNoteId();
        $this->whenDeleteRelationsToNoteIdMethodIsCalled();
        $this->thenRelationToNoteIdIsDeleted();
    }

    public function testGetNoteIdsByTagId(): void
    {
        $this->givenMultipleExistingRelationsAndOneUnrelatedNoteId();
        $this->whenGetNoteIdsByTagIdMethodIsCalled();
        $this->thenNoteIdsAreReturned();
    }

    public function testGetTagIdsByNoteId(): void
    {
        $this->givenMultipleExistingRelationsAndOneUnrelatedNoteId();
        $this->whenGetTagIdsByNoteIdMethodIsCalled();
        $this->thenTagIdsAreReturned();
    }

    public function testGetIsolatedTagsNoteId(): void
    {
        $this->givenMultipleExistingRelationsAndOneUnrelatedNoteId();
        $this->whenGetIsolatedTagsByNoteIdMethodIsCalled();
        $this->thenASingleTagIsReturned();
    }

    private function makeNoteTagRepository(): NoteTagRepository
    {
        /**
         * @var NoteTagRepository $noteTagRepository
         */
        $noteTagRepository = app(NoteTagRepository::class);

        $this->noteTagRepository = $noteTagRepository;
        self::assertInstanceOf(NoteTagRepository::class, $noteTagRepository);

        return $noteTagRepository;
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

    private function makeTagsRepository(): TagsRepository
    {
        /**
         * @var TagsRepository $tagsRepository
         */
        $tagsRepository = app(TagsRepository::class);

        $this->tagsRepository = $tagsRepository;
        self::assertInstanceOf(TagsRepository::class, $tagsRepository);

        return $tagsRepository;
    }

    private function givenExistingTagAndRelatedNote(): void
    {
        $this->notesRepository->createNote($this->givenExistingNote);
        $this->tagsRepository->createTag(
            TagId::fromString(self::TAG_ID_1),
            TagLabel::fromString(self::LABEL),
        );

    }

    private function givenExistingRelation(): void
    {
        $this->noteTagRepository->createRelation(new NoteTag(
            NoteId::fromString(self::NOTE1_CONTAINS_TAG1_TAG2),
            TagId::fromString(self::TAG_ID_1))
        );
    }

    private function givenMultipleExistingRelationsAndOneUnrelatedNoteId(): void
    {
        $this->noteTagRepository->createRelation(new NoteTag(
                NoteId::fromString(self::NOTE1_CONTAINS_TAG1_TAG2),
                TagId::fromString(self::TAG_ID_1))
        );
        $this->noteTagRepository->createRelation(new NoteTag(
                NoteId::fromString(self::NOTE1_CONTAINS_TAG1_TAG2),
                TagId::fromString(self::TAG_ID_2))
        );
        $this->noteTagRepository->createRelation(new NoteTag(
                NoteId::fromString(self::NOTE2_CONTAINS_TAG1_TAG3),
                TagId::fromString(self::TAG_ID_1))
        );
        $this->noteTagRepository->createRelation(new NoteTag(
                NoteId::fromString(self::NOTE2_CONTAINS_TAG1_TAG3),
                TagId::fromString(self::TAG_ID_3))
        );
    }

    private function whenCreateRelationMethodIsCalled(): void
    {
        $this->noteTagRepository->createRelation(new NoteTag(
            NoteId::fromString(self::NOTE1_CONTAINS_TAG1_TAG2),
            TagId::fromString(self::TAG_ID_1),
        ));
    }

    private function whenDeleteByNoteIdMethodIsCalled(): void
    {
        $this->noteTagRepository->deleteByNoteId(
            NoteId::fromString(self::NOTE1_CONTAINS_TAG1_TAG2)
        );
    }

    private function whenDeleteRelationsToNoteIdMethodIsCalled(): void
    {
        $this->noteTagRepository->deleteRelationsToNoteId(
            NoteId::fromString(self::NOTE2_CONTAINS_TAG1_TAG3)
        );
    }

    private function whenGetNoteIdsByTagIdMethodIsCalled(): array
    {
        return $this->noteTagRepository->getNoteIdsByTagId(
            TagId::fromString(self::TAG_ID_2)
        )->toArray();
    }

    private function whenGetTagIdsByNoteIdMethodIsCalled(): array
    {
        return $this->noteTagRepository->getTagIdsByNoteId(
            NoteId::fromString(self::NOTE1_CONTAINS_TAG1_TAG2)
        );
    }

    private function whenGetIsolatedTagsByNoteIdMethodIsCalled(): array
    {
        return $this->noteTagRepository->getIsolatedTagsByNoteId(
            NoteId::fromString(self::NOTE1_CONTAINS_TAG1_TAG2)
        )->toArray();
    }

    private function thenRelationIsPersisted(): void
    {
        $this->assertDatabaseHas(
            'note_tag',
            [
                'note_id' => self::NOTE1_CONTAINS_TAG1_TAG2,
                'tag_id' => self::TAG_ID_1,
            ]
        );
    }

    private function thenRelationIsDeleted(): void
    {
        $this->assertDatabaseMissing(
            'note_tag',
            [
                'note_id' => self::NOTE1_CONTAINS_TAG1_TAG2,
                'tag_id' => self::TAG_ID_1,
            ]
        );
    }

    private function thenRelationToNoteIdIsDeleted(): void
    {
        $this->assertDatabaseMissing(
            'note_tag',
            [
                'note_id' => self::NOTE2_CONTAINS_TAG1_TAG3,
                'tag_id' => self::TAG_ID_1
            ],
        );
        $this->assertDatabaseMissing(
            'note_tag',
            [
                'note_id' => self::NOTE2_CONTAINS_TAG1_TAG3,
                'tag_id' => self::TAG_ID_3
            ],
        );
    }

    private function thenNoteIdsAreReturned(): void
    {
        $result = $this->whenGetNoteIdsByTagIdMethodIsCalled();
        $this->assertEquals(
            [self::NOTE1_CONTAINS_TAG1_TAG2],
            $result
        );
    }

    private function thenTagIdsAreReturned(): void
    {
        $result = $this->whenGetTagIdsByNoteIdMethodIsCalled();
        $this->assertEquals(
            [self::TAG_ID_1, self::TAG_ID_2],
            $result
        );
    }

    private function thenASingleTagIsReturned(): void
    {
        $result = $this->whenGetIsolatedTagsByNoteIdMethodIsCalled();

        $this->assertEquals(
            [self::TAG_ID_2],
            $result
        );
    }

}
