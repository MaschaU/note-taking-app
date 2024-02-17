<?php

namespace App\Infrastructure\Outbound\Persistance\Repository;

use App\Domain\Model\NoteTag;
use App\Domain\Repository\NoteTagRepositoryInterface;
use App\Domain\ValueObject\NoteId;
use App\Domain\ValueObject\TagId;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class NoteTagRepository implements NoteTagRepositoryInterface
{
    private const TABLE = 'note_tag';

    public function createRelation(NoteTag $noteTagRelation): void
    {
        DB::table(self::TABLE)
            ->insert($noteTagRelation
            ->toArray());
    }

    public function deleteByNoteId(NoteId $noteId): void
    {
        DB::table(self::TABLE)
            ->where('note_id', '=', $noteId->toString())
            ->delete();
    }

    public function getTagIdsByNoteId(NoteId $noteId): ?array
    {
        $relations = DB::table(self::TABLE)
            ->where(['note_id' => $noteId])
            ->pluck('tag_id')
        ;

        return $relations->toArray();
    }

    public function getIsolatedTagsByNoteId(NoteId $noteId): Collection
    {
        return DB::table('note_tag as nt')
            ->leftJoin('note_tag as nt_other', function ($join) {
                $join->on('nt.tag_id', '=', 'nt_other.tag_id')
                    ->where('nt.note_id', '<>', DB::raw('nt_other.note_id'));
            })
            ->whereNull('nt_other.tag_id')
            ->where('nt.note_id', '=', $noteId)
            ->select('nt.tag_id')
            ->get()
            ->pluck('tag_id')
        ;
    }

    public function deleteRelationsToNoteId(NoteId $noteId): ?array
    {
        $tagIds = $this->getIsolatedTagsByNoteId($noteId)
            ->toArray()
        ;
        $this->deleteByNoteId($noteId);

        return $tagIds;
    }


    public function getNoteIdsByTagId(TagId $tagId): Collection
    {
        return DB::table(self::TABLE)
            ->select()
            ->where('tag_id', $tagId)
            ->get()
            ->pluck('note_id')
        ;
    }
}
