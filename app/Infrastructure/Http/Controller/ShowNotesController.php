<?php

namespace App\Infrastructure\Http\Controller;

use App\Domain\Repository\NotesRepositoryInterface;
use App\Infrastructure\Http\Request\ShowNotesRequest;
use Illuminate\Http\JsonResponse;

class ShowNotesController extends Controller
{
    public function __construct(
        private readonly NotesRepositoryInterface $notesRepository,
    ) {
    }

    public function __invoke(ShowNotesRequest $request): JsonResponse
    {
        $notes = $this->notesRepository->getAll();

        return response()->json($notes, 200);
    }
}
