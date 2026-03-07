<?php

declare(strict_types=1);

namespace Thomas\Boards\Providers\RealTimeTrains;

use stdClass;
use Thomas\Boards\Domain\Board;
use Thomas\Boards\Domain\BoardTitle;
use Thomas\Boards\Domain\BoardType;
use Thomas\Boards\Domain\Messages;
use Thomas\Boards\Domain\OperatorCode;
use Thomas\Boards\Domain\OperatorCodes;
use Thomas\Boards\Domain\Service;
use Thomas\Boards\Domain\Services;
use Thomas\Shared\Domain\CRS;

final class RTTBoardMapper
{
    public function toDepartureBoard(stdClass $data): Board
    {
        return new Board(
            new BoardTitle(CRS::fromString($data->location->crs)->name()),
            BoardType::DEPARTURES,
            $this->parseServices($data->services, BoardType::DEPARTURES),
            new Messages([]),
            $this->getOperators($data->services)
        );
    }

    public function toArrivalBoard(stdClass $data): Board
    {
        return new Board(
            new BoardTitle(CRS::fromString($data->location->crs)->name()),
            BoardType::ARRIVALS,
            $this->parseServices($data->services, BoardType::ARRIVALS),
            new Messages([]),
            $this->getOperators($data->services)
        );
    }

    public function toPlatformBoard(stdClass $data): Board
    {
        return new Board(
            new BoardTitle(CRS::fromString($data->location->crs)->name()),
            BoardType::PLATFORM,
            $this->parseServices($data->services, BoardType::PLATFORM),
            new Messages([]),
            $this->getOperators($data->services)
        );

    }

    private function parseServices(array $services, BoardType $type): Services
    {
        return new Services(
            array_map(
                fn (stdClass $service) => $this->parseService($service, $type),
                $services
            )
        );
    }

    private function parseService(stdClass $service, BoardType $type): Service
    {
        return new Service(
            $this->getScheduledTime($service->locationDetail, $type),
            $service->serviceUid,
            $this->getDestinationOrOrigin($service->locationDetail, $type),
            $service->locationDetail?->platform ?? '...',
            $this->getExpectedTime($service->locationDetail, $type),
            $service->atocName,
            isset($service->callingPoints) ? $this->getCallingPoints($service->callingPoints) : '',
            isset($service->locationDetail->cancelReasonShortText),
            isset($service->locationDetail->cancelReasonShortText) ? $service->locationDetail->cancelReasonShortText : null
        );
    }

    private function getCallingPoints(array $points): string
    {
        if (!count($points)) {
            return '';
        }

        $points = $this->parseCallingPoints($points);

        if (count($points) === 1) {
            return $points[0];
        }

        $last = array_pop($points);

        return implode(' and ', [implode(', ', $points), $last]);

    }

    private function parseCallingPoints(array $points): array
    {
        return array_map(fn (stdClass $point) => $this->parsePoint($point), $points);
    }

    private function parsePoint(stdClass $point): string
    {
        $name = CRS::fromString($point->crs)->name();

        return "{$name} {$point->realtimeArrival}";
    }

    private function getScheduledTime(stdClass $locationDetail, BoardType $type): string
    {
        return match($type) {
            BoardType::DEPARTURES, BoardType::PLATFORM => $locationDetail->gbttBookedDeparture,
            BoardType::ARRIVALS => $locationDetail->gbttBookedArrival,
        };
    }

    private function getDestinationOrOrigin(stdClass $locationDetail, BoardType $type): string
    {
        return match($type) {
            BoardType::DEPARTURES, BoardType::PLATFORM => $locationDetail->destination[0]->description,
            BoardType::ARRIVALS => $locationDetail->origin[0]->description,
        };
    }

    private function getExpectedTime(stdClass $locationDetail, BoardType $type): string
    {
        if (in_array($locationDetail->displayAs, ['CANCELLED_CALL', 'CANCELLED_PASS'])) {
            return 'Cancelled';
        }

        $expectedTime = match($type) {
            BoardType::DEPARTURES, BoardType::PLATFORM => $locationDetail->realtimeDeparture,
            BoardType::ARRIVALS => $locationDetail->realtimeArrival,
        };

        $scheduledTime = $this->getScheduledTime($locationDetail, $type);

        if ($scheduledTime === $expectedTime) {
            return 'On time';
        }

        return $expectedTime;
    }

    private function getOperators(array $services): OperatorCodes
    {
        return new OperatorCodes(
            array_values(
                array_unique(
                    array_map(
                        fn (stdClass $service) => new OperatorCode($service->atocCode),
                        $services
                    )
                )
            )
        );
    }
}
