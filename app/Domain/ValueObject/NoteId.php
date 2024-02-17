<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Webmozart\Assert\Assert;

final class NoteId
{
    private readonly string $noteId;

    public static function fromString(string $noteId): self
    {
        return new self($noteId);
    }

    private function __construct(string $noteId)
    {
        Assert::uuid($noteId);
        $this->noteId = $noteId;
    }

    public function toString(): string
    {
        return $this->noteId;
    }

    public function __toString(): string
    {
        return $this->noteId;
    }
}
