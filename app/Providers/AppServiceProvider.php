<?php

namespace App\Providers;

use App\Application\UseCase\CreateNote\CreateNoteCommandHandler;
use App\Application\UseCase\CreateNote\CreateNoteHandlerInterface;
use App\Application\UseCase\DeleteNote\DeleteNoteCommandHandler;
use App\Application\UseCase\DeleteNote\DeleteNoteCommandHandlerInterface;
use App\Application\UseCase\EditNote\EditNoteCommandHandler;
use App\Application\UseCase\EditNote\EditNoteCommandHandlerInterface;
use App\Application\UseCase\Generator\NoteIdGeneratorInterface;
use App\Application\UseCase\Generator\TagIdGeneratorInterface;
use App\Domain\Repository\NotesRepositoryInterface;
use App\Domain\Repository\NoteTagRepositoryInterface;
use App\Domain\Repository\TagsRepositoryInterface;
use App\Infrastructure\Outbound\Persistance\Repository\NotesRepository;
use App\Infrastructure\Outbound\Persistance\Repository\NoteTagRepository;
use App\Infrastructure\Outbound\Persistance\Repository\TagsRepository;
use App\Infrastructure\System\NoteIdGenerator;
use App\Infrastructure\System\TagIdGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CreateNoteHandlerInterface::class, CreateNoteCommandHandler::class);
        $this->app->bind(DeleteNoteCommandHandlerInterface::class, DeleteNoteCommandHandler::class);
        $this->app->bind(EditNoteCommandHandlerInterface::class, EditNoteCommandHandler::class);
        $this->app->bind(NotesRepositoryInterface::class, NotesRepository::class);
        $this->app->bind(NoteTagRepositoryInterface::class, NoteTagRepository::class);
        $this->app->bind(TagsRepositoryInterface::class, TagsRepository::class);
        $this->app->bind(NoteIdGeneratorInterface::class, NoteIdGenerator::class);
        $this->app->bind(TagIdGeneratorInterface::class, TagIdGenerator::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
