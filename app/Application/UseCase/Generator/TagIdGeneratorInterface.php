<?php

declare(strict_types=1);

namespace App\Application\UseCase\Generator;

use App\Domain\ValueObject\TagId;

interface TagIdGeneratorInterface
{
    public function generate(): TagId;

}
