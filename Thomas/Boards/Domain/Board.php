<?php

declare(strict_types=1);

namespace Thomas\Boards\Domain;

use JsonSerializable;
use Thomas\Boards\Domain\BoardTitle;
use Thomas\Boards\Domain\BoardType;

final class Board implements JsonSerializable
{
    public function __construct(
        private BoardTitle $boardTitle,
        private BoardType $boardType,
        private array $services,
        private array $messages,
        private array $operators
    ) {
    }

    public function toArray(): array
    {
        return [
            'title'     => $this->boardTitle,
            'type'      => $this->boardType,
            'services'  => $this->services,
            'messages'  => $this->messages,
            'operators' => $this->operators,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
