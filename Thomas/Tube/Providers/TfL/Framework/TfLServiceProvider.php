<?php

declare(strict_types=1);

namespace Thomas\Tube\Providers\TfL\Framework;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Pedros80\TfLphp\Contracts\LineService;
use Pedros80\TfLphp\Factories\ServiceFactory;
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
        /** @var string $key */
        $key = Config::get('services.tfl.key');

        /** @var LineService $lineService */
        $lineService = $this->factory->makeService(ServiceFactory::LINE, $key);

        $this->app->bind(
            TfLService::class,
            fn () => new TfLService($lineService, new TfLMapper())
        );
    }
}
