<?php

declare(strict_types=1);

namespace Tests\Feature\Thomas\Shared\Infrastructure;

use Tests\TestCase;
use Thomas\Shared\Application\DarwinMessageRouter;
use Thomas\Shared\Infrastructure\MockDarwinMessageFactory;

final class InteractsWithDynamoDbTest extends TestCase
{
    public function testGetItemsRecursively(): void
    {
        /** @var DarwinMessageRouter $router */
        $router  = app(DarwinMessageRouter::class);
        $message = MockDarwinMessageFactory::stationMessage(120);
        $router->route($message);
        $router->route($message);

        $this->assertTrue(true);
    }
}
