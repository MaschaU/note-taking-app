<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

final class TagLabel
{
    public function __construct(private readonly string $tagLabel)
    {
    }

    public function toString(): string
    {
        return $this->tagLabel;
    }

    public static function fromString(string $tagLabel): self
    {
        return new self($tagLabel);
    }

    public function __toString(): string
    {
        return $this->tagLabel;
    }
}
