<?php

declare(strict_types=1);

namespace Thomas\Boards\Providers\NationalRailEnquiries;

use function Safe\preg_match;
use stdClass;
use Thomas\Boards\Domain\Board;
use Thomas\Boards\Domain\BoardTitle;
use Thomas\Boards\Domain\BoardType;
use Thomas\Boards\Domain\Exceptions\InvalidBoardType;
use Thomas\Boards\Domain\Service;
use Thomas\Shared\Domain\CRS;

final class NREBoardMapper
{
    public function toDepartureBoard(stdClass $data): Board
    {
        return $this->toBoard($data, BoardType::DEPARTURES);
    }

    public function toArrivalBoard(stdClass $data): Board
    {
        return $this->toBoard($data, BoardType::ARRIVALS);
    }

    public function toPlatformBoard(stdClass $data): Board
    {
        return $this->toBoard($data, BoardType::PLATFORM);
    }

    private function toBoard(stdClass $data, string $type): Board
    {
        $board = $data->GetStationBoardResult;

        return new Board(
            new BoardTitle(CRS::fromString($board->crs)->name()),
            new BoardType($type),
            $this->parseServices($board->trainServices?->service ?? [], $type),
            $this->getMessages($board->nrcMessages?->message ?? []),
            $this->getOperators($board->trainServices?->service ?? [])
        );
    }

    private function cleanMessage(string $message): string
    {
        $message = html_entity_decode($message);
        $message = explode('More details can be found in', $message)[0];
        $message = strip_tags($message);
        $message = trim($message);

        return $message;
    }

    private function parseServices(array $services, string $type): array
    {
        return array_map(
            fn (stdClass $service) => $this->parseService($service, $type),
            $services
        );
    }

    private function parseService(stdClass $service, string $type): Service
    {
        return new Service(
            $this->getScheduledTime($service, $type),
            $service->serviceID,
            $this->getDestinationOrOriginFromLocations($service, $type),
            $this->getPlatform($service),
            $this->getEstimatedTime($service, $type),
            $service->operator,
            $this->getCallingAt($service->subsequentCallingPoints?->callingPointList[0]->callingPoint ?? []),
            isset($service->isCancelled),
            isset($service->isCancelled) ? $service->cancelReason : null
        );
    }

    private function parseCallingPoints(array $points): array
    {
        return array_map(
            fn (stdClass $point) => "{$point->locationName} ({$this->getTimeFromPoint($point)})",
            $points
        );
    }

    private function getCallingAt(array $points): string
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

    private function getTimeFromPoint(stdClass $point): string
    {
        $time = $point->et === 'On time' ? $point->st : $point->et;

        return $this->cleanTimeString($time);
    }

    private function cleanTimeString(string $time): string
    {
        if (strpos($time, ':') && preg_match('/^[0-2][0-9]:[0-9][0-9]$/', $time)) {
            $time = str_replace(':', '', $time);
        }

        return $time;
    }

    private function getScheduledTime(stdClass $service, string $type): string
    {
        $time = match($type) {
            BoardType::DEPARTURES, BoardType::PLATFORM => $service->std,
            BoardType::ARRIVALS => $service->sta,
            default             => throw InvalidBoardType::fromString($type),
        };

        return $this->cleanTimeString($time);
    }

    private function getPlatform(stdClass $service): string
    {
        return isset($service->platform) ? $service->platform : '...';
    }

    private function getEstimatedTime(stdClass $service, string $type): string
    {
        $time = match($type) {
            BoardType::DEPARTURES, BoardType::PLATFORM => $service->etd,
            BoardType::ARRIVALS => $service->eta,
            default             => throw InvalidBoardType::fromString($type),
        };

        return $this->cleanTimeString($time);
    }

    private function getDestinationOrOriginFromLocations(stdClass $service, string $type): string
    {
        $locations = match ($type) {
            BoardType::DEPARTURES, BoardType::PLATFORM => $service->destination->location,
            BoardType::ARRIVALS => $service->origin->location,
            default             => throw InvalidBoardType::fromString($type),
        };

        return implode(
            ' and ',
            array_map(
                fn (stdClass $location) => CRS::fromString($location->crs)->name(),
                $locations
            )
        );
    }

    private function getMessages(array $messages): array
    {
        return array_map(
            fn (stdClass $message) => $this->cleanMessage($message->_),
            $messages
        );
    }

    private function getOperators(array $services): array
    {
        return array_values(
            array_unique(
                array_map(
                    fn (stdClass $service) => $service->operatorCode,
                    $services
                )
            )
        );
    }
}
