<?php

namespace Thomas\ServiceIndicator\Domain;

use JsonSerializable;
use Thomas\ServiceIndicator\Domain\Icon;
use Thomas\ServiceIndicator\Domain\Status;
use Thomas\ServiceIndicator\Domain\TocCode;
use Thomas\ServiceIndicator\Domain\TocName;

final class ServiceIndicator implements JsonSerializable
{
    public function __construct(
        private TocCode $tocCode,
        private TocName $tocName,
        private Status $status,
        private Icon $icon
    ) {
    }

    public function toArray(): array
    {
        return [
            'tocCode' => (string) $this->tocCode,
            'tocName' => (string) $this->tocName,
            'status'  => (string) $this->status,
            'icon'    => (string) $this->icon,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
