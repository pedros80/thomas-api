<?php

declare(strict_types=1);

namespace Thomas\Shared\Framework;

use Illuminate\Contracts\Support\Arrayable;
use Thomas\Shared\Domain\Exceptions\Pagination as PaginationException;
use Thomas\Shared\Domain\Params\PageNumber;
use Thomas\Shared\Domain\Params\PerPage;

final class Pagination implements Arrayable
{
    private int $page;
    private int $perPage;
    private int $total;
    private int $totalPages;
    private ?int $prev;
    private ?int $next;

    public function __construct(PageNumber $page, PerPage $perPage, int $total)
    {
        $perPage = $perPage->getValue();
        $page    = $page->getValue();

        $this->page       = $page;
        $this->perPage    = $perPage;
        $this->total      = $total;
        $totalPages       = (int) ceil($total / $perPage);
        $this->totalPages = $totalPages > 0 ? $totalPages : 1;

        if ($page > $this->totalPages) {
            throw new PaginationException('page cannot be larger than totalPages', 400);
        }

        $this->prev = $this->totalPages > 1 && $page > 1 ? $page - 1 : null;
        $this->next = $this->totalPages > 1 && $page < $this->totalPages ? $page + 1 : null;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function getPrev(): ?int
    {
        return $this->prev;
    }

    public function getNext(): ?int
    {
        return $this->next;
    }

    public function toArray(): array
    {
        $out = [
            'page'       => $this->getPage(),
            'perPage'    => $this->getPerPage(),
            'total'      => $this->getTotal(),
            'totalPages' => $this->getTotalPages(),
            'prev'       => $this->getPrev(),
            'next'       => $this->getNext(),
        ];

        return array_filter($out, fn ($v) => $v !== null);
    }
}
