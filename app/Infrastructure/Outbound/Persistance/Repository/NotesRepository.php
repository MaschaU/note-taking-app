<?php

declare(strict_types=1);

namespace App\Infrastructure\Outbound\Persistance\Repository;

use App\Domain\Model\Note;
use App\Domain\Repository\NotesRepositoryInterface;
use App\Domain\ValueObject\NoteBody;
use App\Domain\ValueObject\NoteId;
use App\Domain\ValueObject\NoteTitle;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class NotesRepository implements NotesRepositoryInterface
{
    private const TABLE = 'notes';
    public function createNote(Note $note): void
    {
        $data = $note->toArray();
        unset($data['tags']);

        DB::table(self::TABLE)->insert($data);
    }

    public function getByNoteId(NoteId $noteId): ?array
    {
        $note =  DB::table(self::TABLE)->where('note_id', $noteId)->first();
        return $note ? (array) $note : null;
    }


    public function deleteNote(NoteId $noteId): void
    {
        DB::table(self::TABLE)->where('note_id', $noteId)->delete();
    }

    public function editNote(NoteId $noteId, ?NoteTitle $noteTitle, ?NoteBody $noteBody): void
    {
        $updateData = [];

        if ($noteTitle !== null) {
            $updateData['title'] = $noteTitle->toString();
        }

        if ($noteBody !== null) {
            $updateData['body'] = $noteBody->toString();
        }

        if (!empty($updateData)) {
            DB::table(self::TABLE)
                ->where('note_id', $noteId->toString())
                ->update($updateData);
        }
    }

    public function getAll(): Collection
    {
        return DB::table(self::TABLE)
            ->select()
            ->get()
        ;
    }

    public function getByNoteIds(array $noteIds): Collection
    {
        return DB::table(self::TABLE)
            ->whereIn('note_id', $noteIds)
            ->get()
        ;
    }
}
