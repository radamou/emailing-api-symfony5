<?php

declare(strict_types=1);

namespace Emailing\Domain\Query\Builder;

class CollectionQueryFilterBuilder
{
    private const REQUEST_PARAM_FILTER = [
        '_end',
        '_order',
        '_sort',
        '_start',
    ];
    private $filters;
    private $standardFilters;

    public function __construct(array $filters)
    {
        $this->setFilters($filters);
        $this->setStandardFilters($filters);
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function setFilters(array $filters): self
    {
        $standardsFilters = self::REQUEST_PARAM_FILTER;

        $filters = \array_filter($filters, function ($key) use ($standardsFilters) {
            return !\in_array($key, $standardsFilters, true);
        }, ARRAY_FILTER_USE_KEY);

        $this->filters = $filters;

        return $this;
    }

    public function getStandardFilters(): array
    {
        return $this->standardFilters;
    }

    public function setStandardFilters(array $filters): self
    {
        $standardsFilters = self::REQUEST_PARAM_FILTER;

        $filters = \array_filter($filters, function ($key) use ($standardsFilters) {
            return \in_array($key, $standardsFilters, true);
        }, ARRAY_FILTER_USE_KEY);

        $this->standardFilters = $filters;

        return $this;
    }
}
