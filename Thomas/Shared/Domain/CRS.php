<?php

declare(strict_types=1);

namespace Thomas\Shared\Domain;

use JsonSerializable;
use Pedros80\NREphp\Exceptions\InvalidStationCode;
use Pedros80\NREphp\Params\StationCode;
use Thomas\Shared\Domain\Exceptions\InvalidCRS;

final class CRS implements JsonSerializable
{
    private function __construct(
        private StationCode $stationCode
    ) {
    }

    public function __toString(): string
    {
        return (string) $this->stationCode;
    }

    public function name(): string
    {
        return $this->stationCode->name();
    }

    public function jsonSerialize(): string
    {
        return (string) $this;
    }

    public static function fromString(string $code): CRS
    {
        try {
            return new CRS(new StationCode(strtoupper($code)));
        } catch (InvalidStationCode) {
            throw InvalidCRS::fromCode($code);
        }
    }

    public static function list(): array
    {
        return StationCode::list();
    }
}
