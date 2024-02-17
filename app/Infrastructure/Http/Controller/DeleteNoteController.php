<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\DeleteNote\DeleteNoteCommand;
use App\Application\UseCase\DeleteNote\DeleteNoteCommandHandlerInterface;
use App\Domain\ValueObject\NoteId;
use App\Infrastructure\Http\Request\DeleteNoteRequest;
use Illuminate\Http\JsonResponse;

final class DeleteNoteController extends Controller
{
    public function __construct(
        private readonly DeleteNoteCommandHandlerInterface $deleteNoteCommandHandler,
    ){
    }

    public function __invoke(DeleteNoteRequest $request): JsonResponse
    {
        $request->validate(['note_id' => 'required|uuid']);

        $command = new DeleteNoteCommand(
            NoteId::fromString($request->input('note_id'))
        );
        $this->deleteNoteCommandHandler->handle($command);

        return response()->json(['message' => 'Note deleted successfully']);

    }
}
