<?php

declare(strict_types=1);

namespace App\Infrastructure\Outbound\Persistance\Repository;

use App\Domain\Model\Tag;
use App\Domain\Repository\TagsRepositoryInterface;
use App\Domain\ValueObject\TagId;
use App\Domain\ValueObject\TagLabel;
use Illuminate\Support\Facades\DB;

final class TagsRepository implements TagsRepositoryInterface
{
    public const TABLE = 'tags';

    public function getById(TagId $tagId): ?array
    {
        $result = DB::table(self::TABLE)
            ->where('tag_id', $tagId)
            ->first();

        return $result ? (array) $result : null;
    }

    public function getByLabel(TagLabel $tagLabel): ?Tag
    {
        $tagFromDatabase = DB::table(self::TABLE)
            ->where('label', $tagLabel)
            ->first();

        if ($tagFromDatabase) {
            $tag = new Tag(
                TagId::fromString($tagFromDatabase->tag_id),
                TagLabel::fromString($tagFromDatabase->label),
            );
        }

        return $tagFromDatabase ? $tag : null;
    }

    public function createTag(TagId $tagId, TagLabel $tagLabel): ?Tag
    {
        $tag = new Tag(
            $tagId,
            $tagLabel,
        );
        $savedTag = DB::table(self::TABLE)->insert($tag->toArray());

        return $savedTag ? $tag : null;
    }

    public function deleteByIds(?array $tagIdsForDeletedRelations): void
    {
        foreach ($tagIdsForDeletedRelations as $tagId) {
            $this->deleteById(TagId::fromString($tagId));
        }
    }

    public function deleteById(TagId $tagId): void
    {
        DB::table(self::TABLE)
            ->where('tag_id', '=', $tagId->toString())
            ->delete();
    }

}
