<?php

declare(strict_types=1);

namespace Tests\Unit\Thomas\Users\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\Users\Domain\Email;
use Thomas\Users\Domain\Exceptions\InvalidEmail;

final class EmailTest extends TestCase
{
    public function testInstantiates(): void
    {
        $email = new Email('peterwsomerville@gmail.com');

        $this->assertInstanceOf(Email::class, $email);
        $this->assertEquals('peterwsomerville@gmail.com', (string) $email);
    }

    public function testInvalidEmailThrowsException(): void
    {
        $this->expectException(InvalidEmail::class);
        $this->expectExceptionMessage("'jobby' is not a valid email address.");

        new Email('jobby');
    }
}
