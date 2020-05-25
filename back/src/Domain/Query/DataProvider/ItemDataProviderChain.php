<?php

declare(strict_types=1);

namespace Emailing\Domain\Query\DataProvider;

use Emailing\Domain\Query\Factory\ItemQueryFactoryInterface;
use Emailing\Domain\Query\Handler\ItemHandlerInterface;

class ItemDataProviderChain implements ItemDataProviderInterface
{
    /** @var ItemHandlerInterface[] */
    private $itemHandlers;

    public function __construct()
    {
        $this->itemHandlers = [];
    }

    public function addHandler(ItemHandlerInterface $handler): void
    {
        $this->itemHandlers[] = $handler;
    }

    public function getItem(string $resourceClass, string $identifier, $hydrate = false)
    {
        /** @var ItemHandlerInterface $handler */
        foreach ($this->itemHandlers as $handler) {
            if (!$handler->support($resourceClass)) {
                continue;
            }

            /** @var ItemQueryFactoryInterface $itemQueryFactory */
            $itemQueryFactory = $handler->getItemFactory();
            $item = $handler->handle($itemQueryFactory->create($identifier), $resourceClass, $hydrate);

            return $item;
        }

        throw new \InvalidArgumentException('ResourceNotFound');
    }
}
