<?php

namespace Thomas\RealTimeIncidents\Domain;

use Thomas\RealTimeIncidents\Domain\Exceptions\InvalidIncidentMessageStatus;

final class IncidentMessageStatus
{
    public const NEW      = 'NEW';
    public const MODIFIED = 'MODIFIED';
    public const REMOVED  = 'REMOVED';

    private const VALID = [
        self::NEW,
        self::MODIFIED,
        self::REMOVED,
    ];

    public function __construct(
        private string $status
    ) {
        if (!in_array($status, self::VALID)) {
            throw InvalidIncidentMessageStatus::fromString($status);
        }
    }

    public function __toString(): string
    {
        return $this->status;
    }

    public static function new(): IncidentMessageStatus
    {
        return new IncidentMessageStatus(IncidentMessageStatus::NEW);
    }

    public static function modified(): IncidentMessageStatus
    {
        return new IncidentMessageStatus(IncidentMessageStatus::MODIFIED);
    }

    public static function removed(): IncidentMessageStatus
    {
        return new IncidentMessageStatus(IncidentMessageStatus::REMOVED);
    }
}
