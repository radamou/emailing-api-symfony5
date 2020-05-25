<?php

declare(strict_types=1);

namespace Emailing\Domain\Query\Handler;

interface ItemHandlerInterface
{
    public function support(string $resourceClass): bool;

    public function handle(object $emailEventQuery, string $resourceClass, bool $hydrate = false);
}
