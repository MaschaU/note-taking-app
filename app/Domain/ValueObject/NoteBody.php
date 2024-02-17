<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

final class NoteBody
{
    public function __construct(private readonly string $noteBody)
    {
    }

    public function toString(): string
    {
        return $this->noteBody;
    }

    public static function fromString(string $noteBody): self
    {
        return new self($noteBody);
    }
}
