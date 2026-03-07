<?php

declare(strict_types=1);

namespace Thomas\Tube\Domain;

use JsonSerializable;
use Thomas\Shared\Domain\NaptanId;
use Thomas\Tube\Domain\CurrentLocation;
use Thomas\Tube\Domain\DestinationName;
use Thomas\Tube\Domain\Direction;
use Thomas\Tube\Domain\PlatformName;
use Thomas\Tube\Domain\StationName;
use Thomas\Tube\Domain\TimeToStation;
use Thomas\Tube\Domain\Towards;
use Thomas\Tube\Domain\TubeLineId;

final class Arrival implements JsonSerializable
{
    public function __construct(
        public readonly StationName $stationName,
        public readonly NaptanId $naptanId,
        public readonly PlatformName $platformName,
        public readonly TubeLineId $lineId,
        public readonly TubeLineName $lineName,
        public readonly DestinationName $destinationName,
        public readonly NaptanId $destinationNaptanId,
        public readonly Towards $towards,
        public readonly TimeToStation $timeToStation,
        public readonly CurrentLocation $currentLocation,
        public readonly ?Direction $direction,
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'stationName'         => $this->stationName,
            'naptanId'            => $this->naptanId,
            'platformName'        => $this->platformName,
            'lineId'              => $this->lineId,
            'lineName'            => $this->lineName,
            'destinationName'     => $this->destinationName,
            'destinationNaptanId' => $this->destinationNaptanId,
            'towards'             => $this->towards,
            'timeToStation'       => $this->timeToStation,
            'currentLocation'     => $this->currentLocation,
            'direction'           => $this->direction,
        ];
    }

    public static function fromArray(array $arrival): Arrival
    {
        return new Arrival(
            new StationName($arrival['stationName']),
            new NaptanId($arrival['naptanId']),
            new PlatformName($arrival['platformName']),
            TubeLineId::fromString($arrival['lineId']),
            new TubeLineName($arrival['lineName']),
            new DestinationName($arrival['destinationName']),
            new NaptanId($arrival['destinationNaptanId']),
            new Towards($arrival['towards']),
            new TimeToStation($arrival['timeToStation']),
            new CurrentLocation($arrival['currentLocation']),
            isset($arrival['direction']) ? Direction::from($arrival['direction']) : null
        );
    }
}
