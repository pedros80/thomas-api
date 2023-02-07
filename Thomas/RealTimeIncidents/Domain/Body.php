<?php

namespace Thomas\RealTimeIncidents\Domain;

use DateTimeImmutable;
use Illuminate\Support\Facades\Log;
use JsonSerializable;
use SimpleXMLElement;

final class Body implements JsonSerializable
{
    private SimpleXMLElement $xml;

    public function __construct(
        private string $body
    ) {
        $this->xml = new SimpleXMLElement($this->body);
    }

    public function __toString(): string
    {
        return $this->body;
    }

    public function summary(): string
    {
        return trim((string) $this->xml->children('ns3', true)->Summary);
    }

    public function description(): string
    {
        return trim((string) $this->xml->children('ns3', true)->Description);
    }

    public function creationTime(): DateTimeImmutable
    {
        return $this->getDate('CreationTime');
    }

    public function lastChanged(): DateTimeImmutable
    {
        return $this->getDate('LastChangedDate', 'ns2');
    }

    public function toArray(): array
    {
        return [
            'summary'      => $this->summary(),
            'description'  => $this->description(),
            'creationTime' => $this->creationTime()->format('Y-m-d H:i:s'),
            'lastChanged'  => $this->lastChanged()->format('Y-m-d H:i:s'),
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    private function getDate(string $attribute, string $namespace = 'ns3'): DateTimeImmutable
    {
        $date = trim((string) $this->xml->children($namespace, true)->$attribute);

        return new DateTimeImmutable($date);
    }
}
