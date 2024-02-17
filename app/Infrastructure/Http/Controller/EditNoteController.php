<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\EditNote\EditNoteCommand;
use App\Application\UseCase\EditNote\EditNoteCommandHandlerInterface;
use App\Domain\ValueObject\NoteBody;
use App\Domain\ValueObject\NoteId;
use App\Domain\ValueObject\NoteTitle;
use App\Infrastructure\Http\Request\EditNoteRequest;
use Illuminate\Http\JsonResponse;

final class EditNoteController extends Controller
{
    public function __construct(
        private readonly EditNoteCommandHandlerInterface $editNoteCommandHandler,
    ){
    }

    public function __invoke(EditNoteRequest $request): JsonResponse
    {
        $request->validate(['note_id' => 'required|uuid']);

        $command = new EditNoteCommand(
            NoteId::fromString($request->input('note_id')),
            NoteTitle::fromString($request->input('title')),
            NoteBody::fromString($request->input('body')),
        );
        $this->editNoteCommandHandler->handle($command);

        return response()->json(['message' => 'Note edited successfully'], 200);
    }
}
