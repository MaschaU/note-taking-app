<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

final class ShowNotesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
        ];
    }
}
