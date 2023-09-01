<?php

declare(strict_types=1);

namespace Thomas\Shared\Domain;

use ArrayIterator;
use Closure;
use Countable;
use IteratorAggregate;
use JsonSerializable;
use Thomas\Shared\Domain\Exceptions\InvalidTypeForCollection;

abstract class TypedCollection implements Countable, IteratorAggregate, JsonSerializable
{
    protected string $type;

    public function __construct(
        protected array $items = []
    ) {
        foreach ($items as $item) {
            if (!is_a($item, $this->type)) {
                throw InvalidTypeForCollection::fromClass($this->type);
            }
        }
    }

    public function jsonSerialize(): array
    {
        return $this->items;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items());
    }

    public function count(): int
    {
        return count($this->items());
    }

    protected function items(): array
    {
        return $this->items;
    }

    public function map(Closure $fn): array
    {
        return array_values(array_map(fn ($item) => $fn($item), $this->items));
    }

    public function filter(Closure $fn): array
    {
        return array_values(array_filter($this->items, $fn));
    }

    public function toArray(): array
    {
        return $this->getIterator()->getArrayCopy();
    }
}
