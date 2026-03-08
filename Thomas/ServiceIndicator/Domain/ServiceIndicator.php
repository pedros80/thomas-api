<?php

declare(strict_types=1);

namespace Thomas\ServiceIndicator\Domain;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;
use Thomas\ServiceIndicator\Domain\Icon;
use Thomas\ServiceIndicator\Domain\Status;
use Thomas\ServiceIndicator\Domain\TocCode;
use Thomas\ServiceIndicator\Domain\TocName;

final class ServiceIndicator implements Arrayable, JsonSerializable
{
    public function __construct(
        public readonly TocCode $tocCode,
        public readonly TocName $tocName,
        public readonly Status $status,
        public readonly Icon $icon,
    ) {
    }

    public function toArray(): array
    {
        return [
            'tocCode' => $this->tocCode,
            'tocName' => $this->tocName,
            'status'  => $this->status,
            'icon'    => $this->icon,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
