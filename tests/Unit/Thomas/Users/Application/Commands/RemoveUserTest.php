<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Users\Application\Commands;

use PHPUnit\Framework\TestCase;
use Thomas\Users\Application\Commands\RemoveUser;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\RemovedAt;

final class RemoveUserTest extends TestCase
{
    public function testInstantiates(): void
    {
        $removedAt = RemovedAt::now();
        $command   = new RemoveUser(
            new Email('peterwsomerville@gmail.com'),
            $removedAt
        );

        $this->assertEquals([
            'email'     => 'peterwsomerville@gmail.com',
            'removedAt' => (string) $removedAt
        ], $command->toArray());
    }
}
