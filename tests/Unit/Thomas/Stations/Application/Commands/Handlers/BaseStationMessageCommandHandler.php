<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Stations\Application\Commands\Handlers;

use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Thomas\Stations\Domain\Events\MessageWasAdded;
use Thomas\Stations\Domain\MessageBody;
use Thomas\Stations\Domain\MessageCategory;
use Thomas\Stations\Domain\MessageId;
use Thomas\Stations\Domain\MessageSeverity;
use Thomas\Stations\Domain\Stations;

abstract class BaseStationMessageCommandHandler extends CommandHandlerScenarioTestCase
{
    protected MessageId $messageId;

    public function setUp(): void
    {
        parent::setUp();

        $this->messageId = new MessageId('12345');
    }

    protected function makeMessageWasAdded(): MessageWasAdded
    {
        return new MessageWasAdded(
            $this->messageId,
            MessageCategory::TRAIN,
            new MessageBody('MESSAGE BODY'),
            MessageSeverity::MAJOR,
            Stations::fromArray([]),
        );
    }
}
