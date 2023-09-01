<?php

declare(strict_types=1);

namespace Thomas\LiftsAndEscalators\Infrastructure;

use GuzzleHttp\Exception\ClientException;
use Pedros80\LANDEphp\Contracts\LiftsAndEscalators;
use function Safe\json_decode;
use function Safe\json_encode;
use stdClass;
use Thomas\LiftsAndEscalators\Domain\Asset;
use Thomas\LiftsAndEscalators\Domain\AssetId;
use Thomas\LiftsAndEscalators\Domain\Assets;
use Thomas\LiftsAndEscalators\Domain\AssetStatus;
use Thomas\LiftsAndEscalators\Domain\AssetStatuses;
use Thomas\LiftsAndEscalators\Domain\Exceptions\AssetNotFound;
use Thomas\LiftsAndEscalators\Domain\Exceptions\NoSensorsFound;
use Thomas\LiftsAndEscalators\Domain\Exceptions\SensorNotFound;
use Thomas\LiftsAndEscalators\Domain\LiftAndEscalatorClient;
use Thomas\LiftsAndEscalators\Domain\SensorId;
use Thomas\LiftsAndEscalators\Domain\TokenService;
use Thomas\Shared\Domain\CRS;
use Thomas\Shared\Domain\Exceptions\ExternalDataConnectionFailure;

final class HttpLiftAndEscalatorClient implements LiftAndEscalatorClient
{
    public function __construct(
        private LiftsAndEscalators $service,
        private TokenService $tokens
    ) {
    }

    public function getAssetsByStationCode(CRS $station): Assets
    {
        $response = $this->service->getAssetsByStationCode(
            station: (string) $station,
            token: (string) $this->tokens->get()
        );

        if (isset($response->errors)) {
            $messages = array_map(
                fn (stdClass $error) => $error->message,
                $response->errors
            );

            throw ExternalDataConnectionFailure::fromErrorAndService('Lifts And Escalators', implode(', ', $messages));
        }

        return new Assets(
            array_map(
                fn (stdClass $asset) => Asset::fromArray(json_decode(json_encode($asset), true)),
                $response->data->assets
            )
        );
    }

    public function getAssetById(AssetId $assetId): Asset
    {
        $response = $this->service->getAssetInfoById(
            id: $assetId->value(),
            token: (string) $this->tokens->get()
        );

        if (isset($response->errors)) {
            $messages = array_map(
                fn (stdClass $error) => $error->message,
                $response->errors
            );

            throw ExternalDataConnectionFailure::fromErrorAndService('Lifts And Escalators', implode(', ', $messages));
        }

        if (!count($response->data->assets)) {
            throw AssetNotFound::fromId($assetId);
        }

        return Asset::fromArray(json_decode(json_encode($response->data->assets[0]), true));
    }

    public function getSensors(int $num=50, int $offset=0): AssetStatuses
    {
        try {
            $response = $this->service->getSensors(
                token: (string) $this->tokens->get(),
                num: $num,
                offset: $offset
            );

        } catch (ClientException $e) {
            $message = json_decode((string) $e->getResponse()->getBody())->error;

            throw ExternalDataConnectionFailure::fromErrorAndService(
                'Lifts And Escalators',
                $message,
                $e->getResponse()->getStatusCode()
            );
        }

        if (isset($response->errors)) {
            $messages = array_map(
                fn (stdClass $error) => $error->message,
                $response->errors
            );

            throw ExternalDataConnectionFailure::fromErrorAndService('Lifts And Escalators', implode(', ', $messages));
        }

        if (!count($response->status)) {
            throw NoSensorsFound::fromOffset($offset);
        }

        return new AssetStatuses(
            array_map(
                fn (stdClass $asset) => AssetStatus::fromArray(json_decode(json_encode($asset), true)),
                $response->status
            )
        );
    }

    public function getSensorById(SensorId $sensorId): AssetStatus
    {
        try {
            $response = $this->service->getSensorInfoById(
                id: $sensorId->value(),
                token: (string) $this->tokens->get()
            );

        } catch (ClientException $e) {

            $message = json_decode((string) $e->getResponse()->getBody())->error;

            throw ExternalDataConnectionFailure::fromErrorAndService(
                'Lifts And Escalators',
                $message,
                $e->getResponse()->getStatusCode()
            );
        }

        if (isset($response->errors)) {
            $messages = array_map(
                fn (stdClass $error) => $error->message,
                $response->errors
            );

            throw ExternalDataConnectionFailure::fromErrorAndService('Lifts And Escalators', implode(', ', $messages));
        }

        if (!count($response->status)) {
            throw SensorNotFound::fromId($sensorId);
        }

        return AssetStatus::fromArray((array) $response->status[0]);
    }
}
