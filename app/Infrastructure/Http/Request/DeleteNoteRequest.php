<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

final class DeleteNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'note_id' => ['required', 'uuid'],
        ];
    }
}
