<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\Stations\Domain\Message;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageId;
use Thomas\Stations\Domain\MessageSeverity;
use Thomas\Stations\Domain\Stations;

final class MessageTest extends TestCase
{
    public function testInstantiates(): void
    {
        $message = new Message(
            new MessageId('1234'),
            MessageCategory::MISC,
            new MessageBody('Some spiel...'),
            MessageSeverity::MAJOR,
            Stations::fromArray([
                ['code' => 'DAM', 'name' => 'Dalmeny'],
                ['code' => 'KDY', 'name' => 'Kirkcaldy'],
            ]),
        );

        $array = [
            'id'       => '1234',
            'category' => MessageCategory::MISC,
            'body'     => 'Some spiel...',
            'severity' => MessageSeverity::MAJOR,
            'stations' => Stations::fromArray([
                ['code' => 'DAM', 'name' => 'Dalmeny'],
                ['code' => 'KDY', 'name' => 'Kirkcaldy'],
            ]),
        ];

        $this->assertEquals($array, $message->toArray());
        $this->assertEquals($array, $message->jsonSerialize());
    }
}
