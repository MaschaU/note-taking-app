<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Webmozart\Assert\Assert;

final class TagId
{
    private readonly string $tagId;

    public static function fromString(string $tagId): self
    {
        return new self($tagId);
    }

    private function __construct(string $tagId)
    {
        Assert::uuid($tagId);
        $this->tagId = $tagId;
    }

    public function toString(): string
    {
        return $this->tagId;
    }

    public function __toString(): string
    {
        return $this->tagId;
    }
}
