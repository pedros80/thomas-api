<?php

declare(strict_types=1);

namespace Thomas\RealTimeIncidents\Domain;

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
        return $this->getAttribute('//ns3:Summary') ?: '';
    }

    public function description(): string
    {
        return $this->getAttribute('//ns3:Description') ?: '';
    }

    public function creationTime(): ?CreationTime
    {
        $attribute = $this->getAttribute('//ns3:CreationTime');

        return $attribute ? CreationTime::fromString($attribute) : null;
    }

    public function lastChanged(): ?LastChangedDate
    {
        $attribute = $this->getAttribute('//ns3:ChangeHistory//ns2:LastChangedDate');

        return $attribute ? LastChangedDate::fromString($attribute) : null;
    }

    public function startTime(): ?StartTime
    {
        $attribute = $this->getAttribute('//ns3:ValidityPeriod//ns2:StartTime');

        return $attribute ? StartTime::fromString($attribute) : null;
    }

    public function endTime(): ?EndTime
    {
        $attribute = $this->getAttribute('//ns3:ValidityPeriod//ns2:EndTime');

        return $attribute ? EndTime::fromString($attribute) : null;
    }

    public function cleared(): bool
    {
        $attribute = $this->getAttribute('//ns3:ClearedIncident');

        return $attribute === 'true';
    }

    public function planned(): bool
    {
        $attribute = $this->getAttribute('//ns3:Planned');

        return $attribute === 'true';
    }

    public function operators(): array
    {
        $nodes = (array) $this->xml->xpath('//ns3:Affects//ns3:Operators//ns3:AffectedOperator//ns3:OperatorRef');

        $out = [];
        foreach ($nodes as $node) {
            $out[] = (string) $node;
        }

        return $out;
    }

    public function toArray(): array
    {
        return [
            'summary'      => $this->summary(),
            'description'  => $this->description(),
            'creationTime' => $this->creationTime()?->format('Y-m-d H:i:s'),
            'lastChanged'  => $this->lastChanged()?->format('Y-m-d H:i:s'),
            'startTime'    => $this->startTime()?->format('Y-m-d H:i:s'),
            'endTime'      => $this->endTime()?->format('Y-m-d H:i:s'),
            'cleared'      => $this->cleared(),
            'planned'      => $this->planned(),
            'operators'    => $this->operators(),
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    private function getAttribute(string $xpath): ?string
    {
        $attribute = $this->xml->xpath($xpath);

        if ($attribute) {
            return trim((string) $attribute[0]);
        }

        return null;
    }
}
