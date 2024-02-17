<?php

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\CreateNote\CreateNoteCommand;
use App\Application\UseCase\CreateNote\CreateNoteHandlerInterface;
use App\Domain\ValueObject\NoteBody;
use App\Domain\ValueObject\NoteTags;
use App\Domain\ValueObject\NoteTitle;
use App\Infrastructure\Http\Request\CreateNoteRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateNoteController extends Controller
{
    public function __construct(
        private readonly CreateNoteHandlerInterface $createNoteHandler,
    ){
    }

    public function __invoke(CreateNoteRequest $request): JsonResponse {
        $request->validate([
            'title' => 'required|string',
            'body' => 'required|string',
            'tags' => 'array',
        ]);
        $command = new CreateNoteCommand(
            NoteTitle::fromString($request->input('title')),
            NoteBody::fromString($request->input('body')),
            NoteTags::fromArray($request->input('tags')),
        );

        $this->createNoteHandler->handle($command);

        return response()->json(['message' => 'Note created successfully'], 201);
    }
}
