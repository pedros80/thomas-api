<?php

namespace Thomas\Stations\Domain;

use Thomas\Stations\Domain\Exceptions\InvalidMessageCategory;

final class MessageCategory
{
    public const TRAIN        = 'Train'; 	    // Affects trains calling at a station
    public const STATION      = 'Station'; 	    // Related to the station, e.g. lifts or escalators
    public const CONNECTIONS  = 'Connections'; 	// Information on other services at a station, e.g. London Underground
    public const SYSTEM       = 'System'; 	    // Related to the operation of Darwin, e.g. feed failure
    public const MISC         = 'Misc'; 	    // Anything not covered by another category
    public const PRIOR_TRAINS = 'PriorTrains'; 	// Advance notices of engineering work
    public const PRIOR_OTHERS = 'PriorOthers'; 	// Advance notices of other work, e.g. planned escalator maintenance work

    private const VALID = [
        self::TRAIN,
        self::STATION,
        self::CONNECTIONS,
        self::SYSTEM,
        self::MISC,
        self::PRIOR_TRAINS,
        self::PRIOR_OTHERS,
    ];

    public function __construct(
        private string $category
    ) {
        if (!in_array($category, self::VALID)) {
            throw InvalidMessageCategory::fromString($category);
        }
    }

    public function __toString(): string
    {
        return $this->category;
    }
}
