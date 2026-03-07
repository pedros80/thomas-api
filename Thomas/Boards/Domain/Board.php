<?php

declare(strict_types=1);

namespace Thomas\Boards\Domain;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;
use Thomas\Boards\Domain\BoardTitle;
use Thomas\Boards\Domain\BoardType;
use Thomas\Boards\Domain\Messages;
use Thomas\Boards\Domain\Services;

final class Board implements Arrayable, JsonSerializable
{
    public function __construct(
        public readonly BoardTitle $title,
        public readonly BoardType $type,
        public readonly Services $services,
        public readonly Messages $messages,
        public readonly OperatorCodes $operators
    ) {
    }

    public function toArray(): array
    {
        return [
            'title'     => $this->title,
            'type'      => $this->type,
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
