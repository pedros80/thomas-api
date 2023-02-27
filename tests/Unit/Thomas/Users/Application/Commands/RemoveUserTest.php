<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Users\Application\Commands;

use PHPUnit\Framework\TestCase;
use Thomas\Users\Application\Commands\RemoveUser;
use Thomas\Users\Domain\Email;

final class RemoveUserTest extends TestCase
{
    public function testInstantiates(): void
    {
        $command = new RemoveUser(
            new Email('peterwsomerville@gmail.com'),
        );

        $this->assertEquals([
            'email' => 'peterwsomerville@gmail.com',
        ], $command->toArray());
    }
}
