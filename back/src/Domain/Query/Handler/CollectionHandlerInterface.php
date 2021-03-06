<?php

declare(strict_types=1);

namespace Emailing\Domain\Query\Handler;

interface CollectionHandlerInterface
{
    public function support(string $resourceClass): bool;

    public function handle(object $emailEventQuery, string $resourceClass);
}
