<?php

declare(strict_types=1);

namespace Thomas\Boards\Infrastructure;

use stdClass;
use Thomas\Boards\Domain\BoardClient;
use Thomas\Boards\Domain\BoardService;

final class HttpBoardService implements BoardService
{
    public function __construct(
        private BoardClient $client,
        private int $numRows
    ) {
    }

    public function departures(string $station): stdClass
    {
        return $this->getBoard($station, 'getDepBoardWithDetails');
    }

    public function arrivals(string $station): stdClass
    {
        return $this->getBoard($station, 'getArrBoardWithDetails');
    }

    public function departuresPlatform(string $station, string $platform): stdClass
    {
        $data = $this->getBoard($station, 'getDepBoardWithDetails');

        if (!isset($data->GetStationBoardResult->trainServices)) {
            return $data;
        }

        $platformServices = [];
        foreach ($data->GetStationBoardResult->trainServices->service as $service) {
            if (isset($service->platform) && $service->platform === $platform) {
                $platformServices[] = $service;
            }
        }

        $data->GetStationBoardResult->trainServices->service = $platformServices;

        return $data;
    }

    private function getBoard(string $station, string $method): stdClass
    {
        $data = $this->client->$method($this->numRows, strtoupper($station));

        $data->operators = $this->getOperators($data);

        return $this->clean($data);
    }

    private function clean(stdClass $data): stdClass
    {
        $data = $this->cleanNrccMessages($data);
        $data = $this->cleanBusServices($data);

        return $data;
    }

    private function cleanBusServices(stdClass $data): stdClass
    {
        if (isset($data->GetStationBoardResult->busServices)) {
            unset($data->GetStationBoardResult->busServices);
        }

        return $data;
    }

    private function cleanNrccMessages(stdClass $data): stdClass
    {
        if (!isset($data->GetStationBoardResult->nrccMessages)) {
            return $data;
        }

        foreach ($data->GetStationBoardResult->nrccMessages->message as $message) {
            $message->_ = html_entity_decode($message->_);
            $message->_ = explode('More details can be found in', $message->_)[0];
            $message->_ = strip_tags($message->_);
        }

        return $data;
    }

    private function getOperators(stdClass $board): array
    {
        if (!isset($board->GetStationBoardResult->trainServices)) {
            return [];
        }

        $operators = [];
        foreach ($board->GetStationBoardResult->trainServices->service as $service) {
            $operators[] = $service->operatorCode;
        }

        $operators = array_unique($operators);

        return $operators;
    }
}
