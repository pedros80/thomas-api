<?php

declare(strict_types=1);

namespace Thomas\News\Domain;

use Illuminate\Http\Request;
use Thomas\Shared\Domain\Exceptions\InvalidOrderBy;
use Thomas\Shared\Domain\Exceptions\InvalidSort;
use Thomas\Shared\Domain\Params\OrderBy;
use Thomas\Shared\Domain\Params\PageNumber;
use Thomas\Shared\Domain\Params\PerPage;
use Thomas\Shared\Domain\Params\QueryOptions;
use Thomas\Shared\Domain\Params\Sort;
use ValueError;

final class NewsItemsOptions extends QueryOptions
{
    public const VALID_ORDERS = [
        'datePublished',
    ];

    public function __construct(
        public readonly PageNumber $pageNumber,
        public readonly PerPage $perPage,
        public readonly Sort $sort,
        public readonly OrderBy $orderBy,
    ) {
    }

    public function getOffset(): int
    {
        return $this->perPage->getValue() * ($this->pageNumber->getValue() - 1);
    }

    public static function fromRequest(Request $request): static
    {
        /** @var string $sort */
        $sort = $request->input('sort', 'DESC');

        try {
            $sorter = Sort::from($sort);
        } catch (ValueError) {
            throw InvalidSort::fromString($sort);
        }

        /** @var int $page */
        $page       = $request->input('page', 1);
        $pageNumber = new PageNumber((int) $page);

        /** @var int $per */
        $per     = $request->input('perPage', 15);
        $perPage = new PerPage((int) $per);

        /** @var string $orderBy */
        $orderBy = $request->input('orderBy', 'datePublished');

        if (!in_array($orderBy, self::VALID_ORDERS)) {
            throw InvalidOrderBy::fromOrderBy($orderBy);
        }

        $orderBy = new OrderBy($orderBy);

        return new NewsItemsOptions($pageNumber, $perPage, $sorter, $orderBy);
    }
}
