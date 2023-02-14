<?php

namespace Tests\Unit\Thomas\Users\Domain;

use PHPUnit\Framework\TestCase;
use Thomas\Users\Domain\Exceptions\InvalidPassword;
use Thomas\Users\Domain\Password;
use Thomas\Users\Domain\PasswordHash;

final class PasswordTest extends TestCase
{
    public function testInstantiates(): void
    {
        $password = new Password('xdu%9BQm%8');

        $this->assertInstanceOf(Password::class, $password);
        $this->assertTrue(password_verify('xdu%9BQm%8', (string) $password));
        $this->assertEquals('xdu%9BQm%8', $password->plain());
        $this->assertInstanceOf(PasswordHash::class, $password->hash());
    }

    public function testTooShort(): void
    {
        $this->expectException(InvalidPassword::class);
        $this->expectExceptionMessage('Invalid Password: Password must be at least 8 characters long');

        new Password('PassW1');
    }

    public function testNoLower(): void
    {
        $this->expectException(InvalidPassword::class);
        $this->expectExceptionMessage('Invalid Password: Password must contain at least 1 lowercase character');

        new Password('PASSWORD1');
    }

    public function testNoUpper(): void
    {
        $this->expectException(InvalidPassword::class);
        $this->expectExceptionMessage('Invalid Password: Password must contain at least 1 uppercase character');

        new Password('password1');
    }

    public function testNoSpecial(): void
    {
        $this->expectException(InvalidPassword::class);
        $this->expectExceptionMessage('Invalid Password: Password must contain at least 1 special character');

        new Password('Password');
    }

    public function testNoMultiple(): void
    {
        $message = 'Invalid Password: Password must contain at least 1 uppercase character, ' .
        'Password must contain at least 1 lowercase character';
        $this->expectException(InvalidPassword::class);
        $this->expectExceptionMessage($message);

        new Password('12345678');
    }

    public function testGenerate(): void
    {
        $password = Password::generate();
        $this->assertInstanceOf(Password::class, $password);
    }
}
