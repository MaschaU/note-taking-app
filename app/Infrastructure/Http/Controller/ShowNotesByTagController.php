<?php

namespace App\Infrastructure\Http\Controller;

use App\Domain\Repository\NotesRepositoryInterface;
use App\Domain\Repository\NoteTagRepositoryInterface;
use App\Domain\ValueObject\TagId;
use App\Infrastructure\Http\Request\ShowNotesByTagRequest;
use Illuminate\Http\JsonResponse;

class ShowNotesByTagController extends Controller
{
    public function __construct(
        private readonly NotesRepositoryInterface $notesRepository,
        private readonly NoteTagRepositoryInterface $noteTagRepository,
    ){
    }

    public function __invoke(ShowNotesByTagRequest $request, string $tagId): JsonResponse {

        $noteIds = $this->noteTagRepository->getNoteIdsByTagId(TagId::fromString($tagId))->toArray();

        if(empty($noteIds)) {
            return response()->json(['message' => 'No notes match the requested tag'], 404);
        }
        $notes = $this->notesRepository->getByNoteIds($noteIds);

        return response()->json($notes);
    }
}
