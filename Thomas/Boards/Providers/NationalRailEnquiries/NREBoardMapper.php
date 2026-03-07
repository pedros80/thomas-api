<?php

declare(strict_types=1);

namespace Thomas\Boards\Providers\NationalRailEnquiries;

use stdClass;
use Thomas\Boards\Domain\Board;
use Thomas\Boards\Domain\BoardTitle;
use Thomas\Boards\Domain\BoardType;
use Thomas\Boards\Domain\Message;
use Thomas\Boards\Domain\Messages;
use Thomas\Boards\Domain\OperatorCode;
use Thomas\Boards\Domain\OperatorCodes;
use Thomas\Boards\Domain\Service;
use Thomas\Boards\Domain\Services;
use Thomas\Shared\Domain\CRS;

use function Safe\preg_match;

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

    private function toBoard(stdClass $data, BoardType $type): Board
    {
        $board = $data->GetStationBoardResult;

        return new Board(
            new BoardTitle(CRS::fromString($board->crs)->name()),
            $type,
            $this->parseServices($board->trainServices->service ?? [], $type),
            $this->parseMessages($board->nrcMessages->message ?? []),
            $this->getOperators($board->trainServices->service ?? [])
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

    private function getScheduledTime(stdClass $service, BoardType $type): string
    {
        $time = match($type) {
            BoardType::DEPARTURES, BoardType::PLATFORM => $service->std,
            BoardType::ARRIVALS => $service->sta,
        };

        return $this->cleanTimeString($time);
    }

    private function getPlatform(stdClass $service): string
    {
        return isset($service->platform) ? $service->platform : '...';
    }

    private function getEstimatedTime(stdClass $service, BoardType $type): string
    {
        $time = match($type) {
            BoardType::DEPARTURES, BoardType::PLATFORM => $service->etd,
            BoardType::ARRIVALS => $service->eta,
        };

        return $this->cleanTimeString($time);
    }

    private function getDestinationOrOriginFromLocations(stdClass $service, BoardType $type): string
    {
        $locations = match ($type) {
            BoardType::DEPARTURES, BoardType::PLATFORM => $service->destination->location,
            BoardType::ARRIVALS => $service->origin->location,
        };

        return implode(
            ' and ',
            array_map(
                fn (stdClass $location) => CRS::fromString($location->crs)->name(),
                $locations
            )
        );
    }

    private function parseMessages(array $messages): Messages
    {
        return new Messages(
            array_map(
                fn (stdClass $message) => new Message($this->cleanMessage($message->_)),
                $messages
            )
        );
    }

    private function getOperators(array $services): OperatorCodes
    {
        return new OperatorCodes(
            array_values(
                array_unique(
                    array_map(
                        fn (stdClass $service) => new OperatorCode($service->operatorCode),
                        $services
                    )
                )
            )
        );
    }
}
