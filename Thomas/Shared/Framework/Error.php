<?php

declare(strict_types=1);

namespace Thomas\Shared\Framework;

use Illuminate\Contracts\Support\Arrayable;
use Throwable;

use function Safe\preg_split;

final class Error implements Arrayable
{
    public function __construct(
        private readonly int $code,
        private readonly string $title,
        private readonly string $detail,
    ) {
    }

    private function getHumanReadableTitle(string $title): string
    {
        $title_arr = explode('\\', $title);
        $title     = $title_arr[count($title_arr) - 1];

        // Match zero-length positions with either preceding lowercase+UPPERCASE characters (end of words) or
        // followed by UPPERCASE+UPPERCASE+lowercase characters (beginning of words following uppercase letters)
        // And insert a space there to break up the words
        // This won't match sequential uppercase letters such as JWT
        $regex = '/(((?<=[a-z])(?=[A-Z]))|(?<=[A-Z])(?=[A-Z][a-z]))/';

        return trim(implode(' ', preg_split($regex, $title)));
    }

    public function toArray(): array
    {
        return [
            'code'   => $this->code === 0 ? 400 : $this->code,
            'title'  => $this->getHumanReadableTitle($this->title),
            'detail' => $this->detail,
        ];
    }

    public static function fromException(Throwable $e): Error
    {
        return new Error($e->getCode(), get_class($e), $e->getMessage());
    }
}
