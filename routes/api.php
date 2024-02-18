<?php

use App\Infrastructure\Http\Controller\CreateNoteController;
use App\Infrastructure\Http\Controller\DeleteNoteController;
use App\Infrastructure\Http\Controller\EditNoteController;
use App\Infrastructure\Http\Controller\ShowNotesByTagController;
use App\Infrastructure\Http\Controller\ShowNotesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('post', [CreateNoteController::class, 'update']);

Route::group(
    [
    'prefix' => 'v1',
    ],
    fn (): array => [
        Route::post('create-note', CreateNoteController::class),
        Route::post('delete-note', DeleteNoteController::class),
        Route::post('edit-note', EditNoteController::class),
        Route::get('show-notes', ShowNotesController::class),
        Route::get('show-notes-for-tag/{tag_id}', ShowNotesByTagController::class),
    ]
);
