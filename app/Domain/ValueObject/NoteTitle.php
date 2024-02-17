<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

final class NoteTitle
{
    public function __construct(private readonly string $noteTitle)
    {
    }

    public function toString(): string
    {
        return $this->noteTitle;
    }

    public static function fromString(string $noteTitle): self
    {
        return new self($noteTitle);
    }
}
