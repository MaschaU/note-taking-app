<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

class NoteTags
{
    public function __construct(
        private readonly array $tags,
    ) {
    }

    public function toArray(): array
    {
        return $this->tags;
    }

    //    public function toString(): string
    //    {
    //        return implode(', ', $this->tags);
    //    }

    public static function fromArray(array $tags): self
    {
        return new self($tags);
    }

    //    public static function fromString(string $tagsString): self
    //    {
    //        $tags = explode(', ', $tagsString);
    //        return new self($tags);
    //    }
}
