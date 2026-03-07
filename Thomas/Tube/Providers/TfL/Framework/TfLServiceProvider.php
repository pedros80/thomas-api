<?php

declare(strict_types=1);

namespace Thomas\Tube\Providers\TfL\Framework;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Pedros80\TfLphp\Contracts\LineService;
use Pedros80\TfLphp\Factories\ServiceFactory;
use Pedros80\TfLphp\Services\Service;
use RuntimeException;
use Thomas\Tube\Providers\TfL\TfLMapper;
use Thomas\Tube\Providers\TfL\TfLService;

final class TfLServiceProvider extends ServiceProvider
{
    private ServiceFactory $factory;

    public function register(): void
    {
        $this->factory = new ServiceFactory();
        $this->bindService();
    }

    private function bindService(): void
    {
        $key = Config::get('services.tfl.key');

        if (!is_string($key) || $key === '') {
            throw new RuntimeException('Missing TfL API key.');
        }

        $lineService = $this->lineService(
            $this->factory->makeService(ServiceFactory::LINE, $key)
        );

        $this->app->bind(TfLService::class, fn () => new TfLService($lineService, new TfLMapper()));
    }

    private function lineService(Service $service): LineService
    {
        if (! $service instanceof LineService) {
            throw new RuntimeException('Expected line service.');
        }

        return $service;
    }
}
