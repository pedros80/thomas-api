<?php

declare(strict_types=1);

namespace Thomas\Tube\Domain;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;
use Pedros80\TfLphp\Params\Line;
use Thomas\Tube\Domain\Exceptions\InvalidTubeLineId;
use Thomas\Tube\Domain\TubeLineIds;

final class TubeLineId implements Arrayable, JsonSerializable
{
    private function __construct(
        private readonly Line $id,
    ) {
        //
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }

    public function jsonSerialize(): mixed
    {
        return (string) $this;
    }

    public function name(): string
    {
        return $this->id->name();
    }

    public function mode(): string
    {
        return $this->id->mode();
    }

    public function toArray(): array
    {
        return [
            'id'   => (string) $this->id,
            'name' => $this->name(),
            'mode' => $this->mode(),
        ];
    }

    public static function all(): TubeLineIds
    {
        return new TubeLineIds(array_map(fn (string $line) => TubeLineId::fromString($line), array_keys(Line::tube())));
    }

    public static function fromString(string $id): TubeLineId
    {
        if (!in_array($id, array_keys(Line::tube()))) {
            throw InvalidTubeLineId::fromString($id);
        }

        return new TubeLineId(new Line($id));
    }
}
