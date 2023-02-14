<?php

declare(strict_types=1);

namespace Thomas\Users\Domain;

use Thomas\Users\Domain\Exceptions\InvalidPassword;
use Thomas\Users\Domain\PasswordHash;

final class Password
{
    private const LOWER = 'abcdefghjkmnpqrstuvwxyz';
    private const UPPER = 'ABCDEFGHJKMNPQRSTUVWXYZ';
    private const DIGIT = '23456789';
    private const PUNCT = '!@#$%&*?';

    private const POOL = [
        self::LOWER,
        self::UPPER,
        self::DIGIT,
        self::PUNCT,
    ];

    public function __construct(
        private string $content,
        private array $errors = []
    ) {
        $this->checkLength($content);
        $this->checkUpperCase($content);
        $this->checkLowerCase($content);
        $this->checkSpecialCase($content);

        if ($this->errors) {
            throw  InvalidPassword::fromString(implode(', ', $this->errors));
        }
    }

    public function plain(): string
    {
        return $this->content;
    }

    public function hash(): PasswordHash
    {
        return new PasswordHash((string) password_hash($this->content, PASSWORD_BCRYPT, ['cost' => 10]));
    }

    public function __toString(): string
    {
        return (string) $this->hash();
    }

    private function checkLength(string $content): void
    {
        if (strlen($content) < 8) {
            $this->errors[] = 'Password must be at least 8 characters long';
        }
    }

    private function checkUpperCase(string $content): void
    {
        if (strtolower($content) === $content) {
            $this->errors[] = 'Password must contain at least 1 uppercase character';
        }
    }

    private function checkLowerCase(string $content): void
    {
        if (strtoupper($content) === $content) {
            $this->errors[] = 'Password must contain at least 1 lowercase character';
        }
    }

    private function checkSpecialCase(string $content): void
    {
        /** @var string $noAlpha */
        $noAlpha = preg_replace("/[A-Za-z]/", '', $content);
        if (strlen($noAlpha) === 0) {
            $this->errors[] = 'Password must contain at least 1 special character';
        }
    }

    public static function generate(int $length = 10): static
    {
        // one of each first
        $out = array_map(fn (string $chars) => $chars[rand(0, strlen($chars) - 1)], self::POOL);
        $all = implode('', self::POOL);

        for ($i = count($out); $i < $length; ++$i) {
            $out[] = $all[rand(0, strlen($all) - 1)];
        }

        shuffle($out);

        return new static(implode('', $out));
    }
}
