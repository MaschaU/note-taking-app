<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Model\Tag;
use App\Domain\ValueObject\TagId;
use App\Domain\ValueObject\TagLabel;

interface TagsRepositoryInterface
{
    public function getById(TagId $tagId): ?array;

    public function getByLabel(TagLabel $tagLabel): ?Tag;

    public function createTag(TagId $tagId, TagLabel $tagLabel): ?Tag;

    public function deleteById(TagId $tagId): void;

    public function deleteByIds(?array $tagIdsForDeletedRelations): void;
}
