<?php

declare(strict_types=1);

namespace Tests\Unit\Integration;

use App\Domain\ValueObject\TagId;
use App\Domain\ValueObject\TagLabel;
use App\Infrastructure\Outbound\Persistance\Repository\TagsRepository;
use Tests\TestCase;

final class TagsRepositoryTest extends TestCase
{
    private const TAG_ID = 'a089205d-cc2f-4d43-9104-643bd1245b9e';

    private const TAG_ID_2 = 'a089205d-cc8f-4d43-9104-643bd1245b9e';

    private const LABEL = 'wow';

    private const LABEL_2 = 'whoa';
    private TagsRepository $tagsRepository;

    private array $givenExistingTag;

    public function setUp(): void
    {
        parent::setUp();
        $this->tagsRepository = $this->makeTagsRepository();
        $this->givenExistingTag = [
            TagId::fromString(self::TAG_ID),
            TagLabel::fromString(self::LABEL),
        ];
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

    public function testCreateTag(): void
    {
        $this->whenCreateTagMethodIsCalled();
        $this->thenTagIsPersistedInTheDatabase();
    }

    public function testGetById(): void
    {
        $this->givenAnExistingNote();
        $this->whenGetByIdMethodIsCalled();
        $this->thenExistingTagIsReturned();
    }

    public function testGetByLabel(): void
    {
        $this->givenAnExistingNote();
        $this->whenGetByLabelMethodIsCalled();
        $this->thenExistingTagIsReturned();
    }

    public function testDeleteById(): void
    {
        $this->givenAnExistingNote();
        $this->whenDeleteByIdMethodIsCalled();
        $this->thenExistingTagIsDeleted();
    }

    public function testDeleteByIds(): void
    {
        $this->givenTwoExistingNotes();
        $this->whenDeleteByIdsMethodIsCalled();
        $this->thenExistingTagsAreDeleted();
    }

    private function givenAnExistingNote(): void
    {
        $this->tagsRepository->createTag(
            TagId::fromString(self::TAG_ID),
            TagLabel::fromString(self::LABEL),
        );
    }

    private function givenTwoExistingNotes(): void
    {
        $this->tagsRepository->createTag(
            TagId::fromString(self::TAG_ID),
            TagLabel::fromString(self::LABEL),
        );
        $this->tagsRepository->createTag(
            TagId::fromString(self::TAG_ID_2),
            TagLabel::fromString(self::LABEL_2),
        );
    }

    private function whenCreateTagMethodIsCalled(): void
    {
        $this->tagsRepository->createTag(
            TagId::fromString(self::TAG_ID),
            TagLabel::fromString(self::LABEL),
        );
    }

    private function thenTagIsPersistedInTheDatabase(): void
    {
        $this->assertDatabaseHas(
            'tags',
            [
                'tag_id' => self::TAG_ID,
                'label' => self::LABEL,
            ]
        );
    }

    private function thenExistingTagIsReturned(): void
    {
        $this->assertEquals(
            [
                TagId::fromString(self::TAG_ID),
                TagLabel::fromString(self::LABEL),
            ],
            $this->givenExistingTag
        );
    }

    private function thenExistingTagIsDeleted(): void
    {
        $this->assertDatabaseMissing(
            'tags',
            [
                'tag_id' => self::TAG_ID,
                'label' => self::LABEL,
            ]
        );
    }

    private function thenExistingTagsAreDeleted(): void
    {
        $this->assertDatabaseMissing(
            'tags',
            [
                'tag_id' => self::TAG_ID,
                'label' => self::LABEL,
            ]
        );
        $this->assertDatabaseMissing(
            'tags',
            [
                'tag_id' => self::TAG_ID_2,
                'label' => self::LABEL_2,
            ]
        );
    }

    private function whenGetByIdMethodIsCalled(): void
    {
        $this->tagsRepository->getById(TagId::fromString(self::TAG_ID));

    }

    private function whenGetByLabelMethodIsCalled(): void
    {
        $this->tagsRepository->getByLabel(TagLabel::fromString(self::LABEL));

    }

    private function whenDeleteByIdMethodIsCalled(): void
    {
        $this->tagsRepository->deleteById(TagId::fromString(self::TAG_ID));

    }

    private function whenDeleteByIdsMethodIsCalled(): void
    {
        $this->tagsRepository->deleteByIds([
            self::TAG_ID,
            self::TAG_ID_2,
        ]);

    }
}
