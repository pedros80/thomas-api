<?php

declare(strict_types=1);

namespace Thomas\Stations\Domain;

enum MessageCategory: string
{
    case TRAIN        = 'Train'; 	    // Affects trains calling at a station
    case STATION      = 'Station'; 	    // Related to the station, e.g. lifts or escalators
    case CONNECTIONS  = 'Connections'; 	// Information on other services at a station, e.g. London Underground
    case SYSTEM       = 'System'; 	    // Related to the operation of Darwin, e.g. feed failure
    case MISC         = 'Misc'; 	    // Anything not covered by another category
    case PRIOR_TRAINS = 'PriorTrains'; 	// Advance notices of engineering work
    case PRIOR_OTHERS = 'PriorOthers'; 	// Advance notices of other work, e.g. planned escalator maintenance work
}
