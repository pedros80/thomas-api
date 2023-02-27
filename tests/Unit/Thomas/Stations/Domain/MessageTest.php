<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\Stations\Domain\Code;
use Thomas\Stations\Domain\Message;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageID;
use Thomas\Stations\Domain\MessageSeverity;
use Thomas\Stations\Domain\Name;
use Thomas\Stations\Domain\Station;

final class MessageTest extends TestCase
{
    public function testInstantiates(): void
    {
        $message = new Message(
            new MessageID('1234'),
            new MessageCategory(MessageCategory::MISC),
            new MessageBody('Some spiel...'),
            new MessageSeverity(2),
            [
                new Station(
                    new Code('DAM'),
                    new Name('Dalmeny')
                ),
                new Station(
                    new Code('KDY'),
                    new Name('Kirkcaldy')
                ),
            ]
        );

        $array = [
            'id'       => '1234',
            'category' => 'Misc',
            'body'     => 'Some spiel...',
            'severity' => 'major',
            'stations' => [
                new Station(
                    new Code('DAM'),
                    new Name('Dalmeny')
                ),
                new Station(
                    new Code('KDY'),
                    new Name('Kirkcaldy')
                ),
            ],
        ];

        $this->assertEquals($array, $message->toArray());
        $this->assertEquals($array, $message->jsonSerialize());
    }
}
